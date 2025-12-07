<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Services\PayMobService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected PayMobService $payMobService;

    public function __construct(PayMobService $payMobService)
    {
        $this->payMobService = $payMobService;
    }

    /**
     * Initiate payment for a booking
     */
    public function initiatePayment(Request $request, Booking $booking)
    {
        // Check if booking already has a successful payment
        if ($booking->successfulPayment) {
            return redirect()->route('customer.bookings')
                ->with('error', __('bookings.already_paid'));
        }

        // Get booking items for payment
        $items = $booking->items->map(function ($item) {
            return [
                'name' => $item->service->name ?? 'Booking Item',
                'amount' => (int)($item->price * 100), // Convert to cents
                'description' => $item->service->description ?? '',
                'quantity' => 1,
            ];
        })->toArray();

        // If no items, create a single item from booking
        if (empty($items)) {
            $items = [
                [
                    'name' => 'Booking - ' . $booking->reference_code,
                    'amount' => (int)($request->input('amount', 0) * 100), // Amount in cents
                    'description' => 'Booking payment',
                    'quantity' => 1,
                ]
            ];
        }

        // Prepare billing data
        $customer = $booking->customer;
        $billingData = [
            'apartment' => 'NA',
            'first_name' => $customer->first_name ?? 'Guest',
            'last_name' => $customer->last_name ?? 'Customer',
            'street' => 'NA',
            'building' => 'NA',
            'phone_number' => $customer->phone ?? '',
            'city' => 'Riyadh',
            'country' => 'SA',
            'email' => $customer->email ?? 'guest@bookify.com',
            'floor' => 'NA',
            'state' => 'NA',
        ];

        // Prepare options
        $options = [
            'currency' => 'SAR',
            'notification_url' => route('payment.webhook'),
            'redirection_url' => route('payment.callback', ['booking' => $booking->id]),
        ];

        // Create intention
        $result = $this->payMobService->createIntention($booking, $items, $billingData, $options);

        if ($result['success']) {
            // Redirect to PayMob checkout
            return redirect($result['checkout_url']);
        }

        return redirect()->back()
            ->with('error', __('bookings.payment_initiation_failed'));
    }

    /**
     * Handle payment callback (after user completes payment)
     */
    public function handleCallback(Request $request, Booking $booking)
    {
        // Get the latest payment for this booking
        $payment = $booking->latestPayment;

        if (!$payment) {
            return redirect()->route('customer.bookings')
                ->with('error', __('bookings.payment_not_found'));
        }

        // Check payment status
        if ($payment->isSuccess()) {
            return redirect()->route('customer.bookings')
                ->with('success', __('bookings.payment_successful'));
        } elseif ($payment->isFailed()) {
            return redirect()->route('customer.bookings')
                ->with('error', __('bookings.payment_failed') . ': ' . $payment->failed_reason);
        }

        // Payment still pending
        return redirect()->route('customer.bookings')
            ->with('info', __('bookings.payment_pending'));
    }

    /**
     * Handle PayMob webhook
     */
    public function handleWebhook(Request $request)
    {
        try {
            $data = $request->all();

            // Log webhook data
            Log::info('PayMob webhook received', $data);

            // Verify HMAC signature (optional but recommended)
            $hmac = $request->query('hmac') ?? $request->header('X-PayMob-Signature');
            
            if ($hmac && !$this->payMobService->verifyWebhookSignature($data, $hmac)) {
                Log::warning('PayMob webhook HMAC verification failed');
                return response()->json(['success' => false, 'message' => 'Invalid signature'], 403);
            }

            // Process the callback
            $processed = $this->payMobService->processCallback($data);

            if ($processed) {
                return response()->json(['success' => true]);
            }

            return response()->json(['success' => false, 'message' => 'Processing failed'], 400);
        } catch (\Exception $e) {
            Log::error('PayMob webhook exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json(['success' => false, 'message' => 'Server error'], 500);
        }
    }

    /**
     * Query payment status
     */
    public function queryPayment(Request $request, Payment $payment)
    {
        $result = null;

        // Try querying by different identifiers
        if ($payment->paymob_transaction_id) {
            $result = $this->payMobService->queryByTransactionId($payment->paymob_transaction_id);
        } elseif ($payment->paymob_order_id) {
            $result = $this->payMobService->queryByOrderId($payment->paymob_order_id);
        } elseif ($payment->merchant_order_id) {
            $result = $this->payMobService->queryByMerchantOrderId($payment->merchant_order_id);
        }

        if ($result) {
            return response()->json([
                'success' => true,
                'payment' => $payment,
                'paymob_data' => $result,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Unable to query payment status',
        ], 404);
    }

    /**
     * Refund a payment
     */
    public function refund(Request $request, Payment $payment)
    {
        // Validate that payment is successful
        if (!$payment->isSuccess()) {
            return response()->json([
                'success' => false,
                'message' => 'Only successful payments can be refunded',
            ], 400);
        }

        // Validate refund amount
        $refundAmountCents = $request->input('amount_cents', $payment->amount_cents);

        if ($refundAmountCents > $payment->amount_cents) {
            return response()->json([
                'success' => false,
                'message' => 'Refund amount cannot exceed payment amount',
            ], 400);
        }

        // Process refund
        $result = $this->payMobService->refund($payment->paymob_transaction_id, $refundAmountCents);

        if ($result) {
            // Mark payment as refunded
            $isPartial = $refundAmountCents < $payment->amount_cents;
            $payment->markAsRefunded($refundAmountCents, $isPartial);

            // Update booking if fully refunded
            if (!$isPartial) {
                $payment->booking->update([
                    'is_paid' => false,
                    'payment_status' => 'refunded',
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Refund processed successfully',
                'refund_data' => $result,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Refund failed',
        ], 500);
    }
}
