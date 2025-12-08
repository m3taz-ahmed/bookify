<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Services\PayMobService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymobController extends Controller
{
    protected $paymobService;

    public function __construct(PayMobService $paymobService)
    {
        $this->paymobService = $paymobService;
    }

    /**
     * Handle Paymob webhook callback
     */
    public function webhook(Request $request)
    {
        try {
            Log::info('Paymob Webhook Received', [
                'payload' => $request->all(),
                'headers' => $request->headers->all(),
            ]);

            // Get the transaction object from the payload
            $data = $request->input('obj');
            
            if (!$data) {
                Log::warning('Paymob webhook: Missing obj in payload');
                return response()->json(['message' => 'Invalid payload'], 400);
            }

            // Verify HMAC signature
            $hmac = $request->query('hmac');
            
            if (!$hmac) {
                Log::warning('Paymob webhook: Missing HMAC');
                return response()->json(['message' => 'Missing HMAC'], 400);
            }

            if (!$this->paymobService->verifyWebhookSignature($data, $hmac)) {
                Log::error('Paymob webhook: Invalid HMAC signature');
                return response()->json(['message' => 'Invalid signature'], 403);
            }

            // Process the callback
            $result = $this->paymobService->processCallback($data);

            if ($result) {
                Log::info('Paymob webhook: Payment processed successfully');
                return response()->json(['message' => 'Payment processed'], 200);
            }

            Log::warning('Paymob webhook: Payment processing failed');
            return response()->json(['message' => 'Processing failed'], 400);

        } catch (\Exception $e) {
            Log::error('Paymob webhook exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json(['message' => 'Server error'], 500);
        }
    }

    /**
     * Handle customer return from Paymob checkout
     */
    public function return(Request $request)
    {
        try {
            Log::info('Paymob Return', [
                'params' => $request->all(),
            ]);

            // Get merchant_order_id from query params
            $merchantOrderId = $request->query('merchant_order_id');
            $success = $request->query('success');
            $transactionId = $request->query('id');

            if (!$merchantOrderId) {
                return redirect()->route('customer.bookings')
                    ->with('error', __('website.payment_verification_failed'));
            }

            // Find the payment
            $payment = Payment::where('merchant_order_id', $merchantOrderId)->first();

            if (!$payment) {
                return redirect()->route('customer.bookings')
                    ->with('error', __('website.payment_not_found'));
            }

            // Get the booking
            $booking = $payment->booking;

            if (!$booking) {
                return redirect()->route('customer.bookings')
                    ->with('error', __('website.booking_not_found'));
            }

            // Redirect to step 5 (payment result) with booking data
            return redirect()->route('customer.bookings.create', [
                'step' => 5,
                'booking_id' => $booking->id,
                'payment_id' => $payment->id,
            ]);

        } catch (\Exception $e) {
            Log::error('Paymob return exception', [
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('customer.bookings')
                ->with('error', __('website.payment_processing_error'));
        }
    }
}
