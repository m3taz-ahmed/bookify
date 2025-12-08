<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PayMobService
{
    protected string $baseUrl;
    protected string $apiKey;
    protected string $secretKey;
    protected string $publicKey;
    protected string $integrationId;
    protected ?string $motoIntegrationId;
    protected ?string $paymobCurrency;
    protected ?string $paymobMode;

    public function __construct()
    {
        $this->baseUrl = config('services.paymob.base_url', 'https://ksa.paymob.com');
        $this->apiKey = config('services.paymob.api_key');
        $this->secretKey = config('services.paymob.secret_key');
        $this->publicKey = config('services.paymob.public_key');
        $this->integrationId = config('services.paymob.integration_id');
        $this->motoIntegrationId = config('services.paymob.moto_integration_id');
        $this->paymobCurrency = config('services.paymob.paymob_currency');
        $this->paymobMode = config('services.paymob.paymob_mode');
    }

    /**
     * Authenticate and get token (for old API methods)
     */
    public function authenticate(): ?string
    {
        try {
            $response = Http::post("{$this->baseUrl}/api/auth/tokens", [
                'api_key' => $this->apiKey,
            ]);

            if ($response->successful()) {
                return $response->json('token');
            }

            Log::error('PayMob authentication failed', [
                'response' => $response->json(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('PayMob authentication exception', [
                'message' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * Create payment intention (V2 API)
     */
    public function createIntention(Booking $booking, array $items, array $billingData, array $options = []): ?array
    {
        try {
            // Calculate total amount in cents
            $totalAmountCents = collect($items)->sum('amount');

            // Create payment record
            $payment = Payment::create([
                'booking_id' => $booking->id,
                'merchant_order_id' => Payment::generateMerchantOrderId(),
                'amount_cents' => $totalAmountCents,
                'currency' => $options['currency'] ?? 'SAR',
                'payment_status' => 'pending',
                'payment_gateway' => 'paymob',
                'paymob_integration_id' => $this->integrationId,
            ]);

            // Prepare intention payload
            $payload = [
                'amount' => $totalAmountCents,
                'currency' => $options['currency'] ?? 'SAR',
                'payment_methods' => [(int)$this->integrationId],
                'items' => $items,
                'billing_data' => $billingData,
                'special_reference' => $payment->merchant_order_id,
            ];

            // Add optional fields
            if (!empty($options['notification_url'])) {
                $payload['notification_url'] = $options['notification_url'];
            }

            if (!empty($options['redirection_url'])) {
                $payload['redirection_url'] = $options['redirection_url'];
            }

            if (!empty($options['extras'])) {
                $payload['extras'] = $options['extras'];
            }

            // Make API request
            $response = Http::withHeaders([
                'Authorization' => "Token {$this->secretKey}",
            ])->post("{$this->baseUrl}/v1/intention/", $payload);

            if ($response->successful()) {
                $responseData = $response->json();

                // Update payment record with PayMob data
                $payment->update([
                    'payment_data' => $responseData,
                ]);

                return [
                    'success' => true,
                    'payment' => $payment,
                    'client_secret' => $responseData['client_secret'] ?? null,
                    'checkout_url' => "{$this->baseUrl}/unifiedcheckout/?publicKey={$this->publicKey}&clientSecret=" . ($responseData['client_secret'] ?? ''),
                    'response' => $responseData,
                ];
            }

            Log::error('PayMob intention creation failed', [
                'response' => $response->json(),
            ]);

            $payment->markAsFailed('Intention creation failed', $response->json());

            return [
                'success' => false,
                'error' => $response->json(),
            ];
        } catch (\Exception $e) {
            Log::error('PayMob intention creation exception', [
                'message' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Query transaction by merchant order ID
     */
    public function queryByMerchantOrderId(string $merchantOrderId): ?array
    {
        try {
            $token = $this->authenticate();
            
            if (!$token) {
                return null;
            }

            $response = Http::post("{$this->baseUrl}/api/ecommerce/orders/transaction_inquiry", [
                'auth_token' => $token,
                'merchant_order_id' => $merchantOrderId,
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('PayMob transaction inquiry failed', [
                'merchant_order_id' => $merchantOrderId,
                'response' => $response->json(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('PayMob transaction inquiry exception', [
                'message' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * Query transaction by PayMob order ID
     */
    public function queryByOrderId(string $orderId): ?array
    {
        try {
            $token = $this->authenticate();
            
            if (!$token) {
                return null;
            }

            $response = Http::post("{$this->baseUrl}/api/ecommerce/orders/transaction_inquiry", [
                'auth_token' => $token,
                'order_id' => $orderId,
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        } catch (\Exception $e) {
            Log::error('PayMob transaction inquiry exception', [
                'message' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * Query transaction by transaction ID
     */
    public function queryByTransactionId(string $transactionId): ?array
    {
        try {
            $token = $this->authenticate();
            
            if (!$token) {
                return null;
            }

            $response = Http::withBody(json_encode([
                'auth_token' => $token,
            ]), 'application/json')
                ->get("{$this->baseUrl}/api/acceptance/transactions/{$transactionId}");

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        } catch (\Exception $e) {
            Log::error('PayMob transaction inquiry exception', [
                'message' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * Refund a transaction
     */
    public function refund(string $transactionId, int $amountCents): ?array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => "Token {$this->secretKey}",
            ])->post("{$this->baseUrl}/api/acceptance/void_refund/refund", [
                'transaction_id' => $transactionId,
                'amount_cents' => $amountCents,
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('PayMob refund failed', [
                'transaction_id' => $transactionId,
                'response' => $response->json(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('PayMob refund exception', [
                'message' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * Void a transaction
     */
    public function void(string $transactionId): ?array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => "Token {$this->secretKey}",
            ])->post("{$this->baseUrl}/api/acceptance/void_refund/void", [
                'transaction_id' => $transactionId,
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('PayMob void failed', [
                'transaction_id' => $transactionId,
                'response' => $response->json(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('PayMob void exception', [
                'message' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * Verify webhook signature (HMAC)
     */
    public function verifyWebhookSignature(array $data, string $receivedHmac): bool
    {
        // PayMob HMAC calculation (check PayMob documentation for exact fields)
        $concatenatedString = implode('', [
            $data['amount_cents'] ?? '',
            $data['created_at'] ?? '',
            $data['currency'] ?? '',
            $data['error_occured'] ?? '',
            $data['has_parent_transaction'] ?? '',
            $data['id'] ?? '',
            $data['integration_id'] ?? '',
            $data['is_3d_secure'] ?? '',
            $data['is_auth'] ?? '',
            $data['is_capture'] ?? '',
            $data['is_refunded'] ?? '',
            $data['is_standalone_payment'] ?? '',
            $data['is_voided'] ?? '',
            $data['order']['id'] ?? '',
            $data['owner'] ?? '',
            $data['pending'] ?? '',
            $data['source_data']['pan'] ?? '',
            $data['source_data']['sub_type'] ?? '',
            $data['source_data']['type'] ?? '',
            $data['success'] ?? '',
        ]);

        $calculatedHmac = hash_hmac('sha512', $concatenatedString, config('services.paymob.hmac_secret'));

        return hash_equals($calculatedHmac, $receivedHmac);
    }

    /**
     * Process webhook callback
     */
    public function processCallback(array $data): bool
    {
        try {
            // Find payment by merchant order ID
            $merchantOrderId = $data['order']['merchant_order_id'] ?? null;
            
            if (!$merchantOrderId) {
                Log::warning('PayMob callback missing merchant_order_id', $data);
                return false;
            }

            $payment = Payment::where('merchant_order_id', $merchantOrderId)->first();

            if (!$payment) {
                Log::warning('Payment not found for merchant_order_id', ['merchant_order_id' => $merchantOrderId]);
                return false;
            }

            // Update payment with transaction details
            $payment->update([
                'paymob_order_id' => $data['order']['id'] ?? null,
                'paymob_transaction_id' => $data['id'] ?? null,
                'callback_data' => $data,
            ]);

            // Check if payment was successful
            if (($data['success'] ?? false) === true || ($data['success'] ?? 'false') === 'true') {
                $payment->markAsSuccess($data);
                
                // Update booking status
                $booking = $payment->booking;
                if ($booking) {
                    $booking->update([
                        'is_paid' => true,
                        'payment_status' => 'paid',
                        'status' => 'confirmed',
                    ]);
                }

                return true;
            } else {
                $failedReason = $data['data']['message'] ?? 'Payment failed';
                $payment->markAsFailed($failedReason, $data);

                return false;
            }
        } catch (\Exception $e) {
            Log::error('PayMob callback processing exception', [
                'message' => $e->getMessage(),
                'data' => $data,
            ]);

            return false;
        }
    }
}
