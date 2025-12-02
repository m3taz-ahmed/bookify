<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MsegatService
{
    protected string $baseUrl;
    protected string $username;
    protected string $apiKey;
    protected string $userSender;

    public function __construct()
    {
        $this->baseUrl = config('services.msegat.base_url', 'https://www.msegat.com/gw');
        $this->username = config('services.msegat.username');
        $this->apiKey = config('services.msegat.api_key');
        $this->userSender = config('services.msegat.sender');
        
    }

    /**
     * Send OTP using Msegat FREE OTP endpoint
     * This endpoint generates and sends OTP automatically
     * 
     * @param string $phoneNumber Phone number in international format (e.g., 966xxxxxxxxx)
     * @return array Response containing status and OTP ID
     */
    public function sendOtpFree(string $phoneNumber): array
    {
        try {
            $response = Http::asJson()->post("{$this->baseUrl}/senOTPFree.php", [
                'userName' => $this->username,
                'apiKey' => $this->apiKey,
                'numbers' => $this->formatPhoneNumber($phoneNumber),
                'userSender' => $this->userSender,
            ]);

            $result = $response->json();

            Log::info('Msegat OTP Free sent', [
                'phone' => $phoneNumber,
                'response' => $result
            ]);

            return [
                'success' => isset($result['code']) && $result['code'] === 'M0000',
                'message' => $result['message'] ?? 'Unknown error',
                'otp_id' => $result['id'] ?? null,
                'code' => $result['code'] ?? null,
            ];
        } catch (\Exception $e) {
            Log::error('Msegat OTP Free failed', [
                'phone' => $phoneNumber,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage(),
                'otp_id' => null,
            ];
        }
    }

    /**
     * Send OTP with custom code using Msegat OTP endpoint
     * 
     * @param string $phoneNumber Phone number in international format
     * @param string $otpCode The OTP code to send
     * @return array Response containing status
     */
    public function sendOtpCode(string $phoneNumber, string $otpCode): array
    {
        try {
            // Get SMS templates from database
            $otpMessageEn = \App\Models\SiteSetting::get('sms_template_otp_en', 'Welcome to SkyBridge. Your verification code is: {otp_code}');
            $otpMessageAr = \App\Models\SiteSetting::get('sms_template_otp_ar', 'مرحباً بك في جسر المشاهدة. رمز التحقق الخاص بك هو: {otp_code}');
            
            // Use Arabic message as default (based on previous implementation)
            $message = str_replace('{otp_code}', $otpCode, $otpMessageAr);
            
            $payload = [
                'userName' => $this->username,
                'numbers' => $this->formatPhoneNumber($phoneNumber),
                'userSender' => $this->userSender,
                'apiKey' => $this->apiKey,
                'msg' => $message,
            ];

            Log::info('Msegat OTP Payload (via SMS)', $payload);

            $response = Http::asJson()->post("{$this->baseUrl}/sendsms.php", $payload);

            $result = $response->json();

            Log::info('Msegat OTP SMS sent', [
                'phone' => $phoneNumber,
                'response' => $result
            ]);

            // Msegat returns '1' for success in some endpoints or 'M0000'
            $code = $result['code'] ?? null;
            $isSuccess = ($code === 'M0000' || $code === '1');

            return [
                'success' => $isSuccess,
                'message' => $result['message'] ?? 'Unknown error',
                'msg_id' => $result['msgID'] ?? null,
                'code' => $code,
            ];
        } catch (\Exception $e) {
            Log::error('Msegat OTP SMS failed', [
                'phone' => $phoneNumber,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Verify OTP code (only works with FREE OTP endpoint)
     * 
     * @param string $otpId The OTP ID returned from sendOtpFree
     * @param string $otpCode The code to verify
     * @return array Response containing verification status
     */
    public function verifyOtpCode(string $otpId, string $otpCode): array
    {
        try {
            $response = Http::asJson()->post("{$this->baseUrl}/verifyOTPCode.php", [
                'userName' => $this->username,
                'apiKey' => $this->apiKey,
                'id' => $otpId,
                'code' => $otpCode,
            ]);

            $result = $response->json();

            Log::info('Msegat OTP Verification', [
                'otp_id' => $otpId,
                'response' => $result
            ]);

            return [
                'success' => isset($result['code']) && $result['code'] === 'M0000',
                'message' => $result['message'] ?? 'Unknown error',
                'code' => $result['code'] ?? null,
            ];
        } catch (\Exception $e) {
            Log::error('Msegat OTP Verification failed', [
                'otp_id' => $otpId,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Send a regular SMS message
     * 
     * @param string $phoneNumber Phone number in international format
     * @param string $message The message to send
     * @return array Response containing status
     */
    public function sendSms(string $phoneNumber, string $message): array
    {
        try {
            $payload = [
                'userName' => $this->username,
                'numbers' => $this->formatPhoneNumber($phoneNumber),
                'userSender' => $this->userSender,
                'apiKey' => $this->apiKey,
                'msg' => $message,
            ];

            Log::info('Msegat SMS Payload', $payload);

            $response = Http::asJson()->post("{$this->baseUrl}/sendsms.php", $payload);

            $result = $response->json();

            Log::info('Msegat SMS Response', [
                'phone' => $phoneNumber,
                'response' => $result
            ]);

            // Msegat returns '1' for success in some endpoints or 'M0000'
            // Let's check both possibilities and log the code
            $code = $result['code'] ?? null;
            $isSuccess = ($code === 'M0000' || $code === '1');

            return [
                'success' => $isSuccess,
                'message' => $result['message'] ?? 'Unknown error',
                'msg_id' => $result['msgID'] ?? null,
                'code' => $code,
            ];
        } catch (\Exception $e) {
            Log::error('Msegat SMS failed', [
                'phone' => $phoneNumber,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Format phone number to international format
     * Removes + and spaces, ensures it starts with country code
     * 
     * @param string $phoneNumber
     * @return string
     */
    protected function formatPhoneNumber(string $phoneNumber): string
    {
        // Remove spaces, dashes, and plus signs
        $phone = preg_replace('/[\s\-\+]/', '', $phoneNumber);
        
        // If phone number is already in international format (starts with country code)
        // and has sufficient length, return as is
        if (preg_match('/^\d{10,15}$/', $phone)) {
            // Check if it starts with a valid country code
            // Common country codes: 966 (SA), 20 (EG), 971 (AE), 965 (KW), etc.
            if (preg_match('/^(966|20|971|965|973|968|974|1|44|33|49|39|34|7|86|81|82|91|92|93|94|95|98|90|62|60|63|84|66|855|856|880|977)/', $phone)) {
                return $phone;
            }
        }
        
        // Legacy support: Check for Saudi local numbers
        
        // Starts with 05 (e.g., 0501234567 -> 966501234567)
        if (preg_match('/^05\d{8}$/', $phone)) {
            return '966' . substr($phone, 1);
        }
        
        // Starts with 5 (e.g., 501234567 -> 966501234567)
        if (preg_match('/^5\d{8}$/', $phone)) {
            return '966' . $phone;
        }
        
        // For all other numbers, assume they are already in international format
        // or let the API handle validation
        return $phone;
    }

    /**
     * Generate a random 6-digit OTP code
     * 
     * @return string
     */
    public function generateOtpCode(): string
    {
        return str_pad((string) random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
    }
}
