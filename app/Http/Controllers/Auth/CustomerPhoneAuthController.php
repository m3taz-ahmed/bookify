<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class CustomerPhoneAuthController extends Controller
{
    public function showPhoneForm()
    {
        return view('auth.customer.phone-login');
    }

    public function showRegistrationForm()
    {
        return view('auth.customer.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:customers',
        ]);

        // Generate and send OTP for new customer registration
        $msegatService = app(\App\Services\MsegatService::class);
        
        // Generate OTP
        $otp = $msegatService->generateOtpCode();
        Log::info('Generated OTP for registration', ['phone' => $request->phone, 'otp' => $otp]);
        
        // Store OTP and name in Cache for 5 minutes
        Cache::put('otp_' . $request->phone, Hash::make($otp), now()->addMinutes(5));
        Cache::put('name_' . $request->phone, $request->name, now()->addMinutes(5));
        
        // Send OTP via Msegat SMS
        $result = $msegatService->sendOtpCode($request->phone, $otp);
        
        if (!$result['success']) {
            Log::warning('Failed to send OTP for registration', [
                'phone' => $request->phone,
                'error' => $result['message']
            ]);
        }

        // Show verification page with name pre-filled and hidden
        $tempCustomer = new \stdClass();
        $tempCustomer->phone = $request->phone;
        $tempCustomer->name = $request->name;
        $hasName = true; // Name is already provided from registration form
        return view('auth.customer.verify-otp-new', compact('tempCustomer', 'hasName'));
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
        ]);

        Log::info('OTP Request Initiated', ['phone' => $request->phone]);

        // Check if customer exists
        $customer = Customer::where('phone', $request->phone)->first();
        
        $msegatService = app(\App\Services\MsegatService::class);
        
        if (!$customer) {
            // New Customer Flow (from login page - need to ask for name)
            Log::info('New Customer Flow detected');
            
            // Generate OTP
            $otp = $msegatService->generateOtpCode();
            Log::info('Generated OTP for new customer', ['otp' => $otp]);
            
            // Store OTP in Cache for 5 minutes (hashed)
            Cache::put('otp_' . $request->phone, Hash::make($otp), now()->addMinutes(5));
            Log::info('OTP cached for new customer', ['key' => 'otp_' . $request->phone]);
            
            // Send OTP via Msegat SMS
            $result = $msegatService->sendOtpCode($request->phone, $otp);
            Log::info('Msegat Send Result', $result);
            
            if (!$result['success']) {
                Log::warning('Failed to send OTP to new customer', [
                    'phone' => $request->phone,
                    'error' => $result['message']
                ]);
            }

            $tempCustomer = new \stdClass();
            $tempCustomer->phone = $request->phone;
            $tempCustomer->name = ''; 
            $hasName = false; // Name is NOT provided, need to ask for it
            return view('auth.customer.verify-otp-new', compact('tempCustomer', 'hasName'));
        }
        
        // Existing Customer Flow
        Log::info('Existing Customer Flow detected', ['customer_id' => $customer->id]);
        $otp = $customer->generateOtp();
        Log::info('Generated OTP for existing customer', ['otp' => $otp]);
        
        // Send OTP via Msegat SMS
        $result = $msegatService->sendOtpCode($customer->phone, $otp);
        Log::info('Msegat Send Result', $result);
        
        if (!$result['success']) {
            Log::warning('Failed to send OTP via SMS', [
                'phone' => $customer->phone,
                'error' => $result['message']
            ]);
        }
        
        return view('auth.customer.verify-otp', compact('customer'));
    }

    public function verifyOtp(Request $request)
    {
        Log::info('OTP Verification Request', $request->all());

        // Check if this is for a new customer
        if ($request->has('is_new_customer')) {
            // Validate for new customer
            $request->validate([
                'phone' => 'required|string',
                'name' => 'sometimes|required|string|max:255',
                'otp' => 'required|string|size:6',
            ]);

            // Retrieve OTP from Cache
            $cachedOtp = Cache::get('otp_' . $request->phone);
            Log::info('Retrieved Cached OTP', ['key' => 'otp_' . $request->phone, 'found' => !empty($cachedOtp)]);
            
            if (!$cachedOtp || !Hash::check($request->otp, $cachedOtp)) {
                Log::warning('OTP Verification Failed (New Customer)', ['provided' => $request->otp]);
                throw ValidationException::withMessages([
                    'otp' => ['The provided OTP is invalid or has expired.'],
                ]);
            }

            // Get name from request or cache
            $name = $request->name ?? Cache::get('name_' . $request->phone);
            
            if (!$name) {
                throw ValidationException::withMessages([
                    'name' => ['Name is required.'],
                ]);
            }

            // Create new customer
            $customer = Customer::create([
                'name' => $name,
                'phone' => $request->phone,
                'email' => null,
                'password' => null,
            ]);
            
            // Clear the OTP and name from cache
            Cache::forget('otp_' . $request->phone);
            Cache::forget('name_' . $request->phone);

            // Log the customer in
            Auth::guard('customer')->login($customer);

            // Redirect to booking page (step 1)
            return redirect()->route('customer.bookings.create');
        } else {
            // Existing customer flow
            $request->validate([
                'phone' => 'required|string|exists:customers,phone',
                'otp' => 'required|string|size:6',
            ]);

            $customer = Customer::where('phone', $request->phone)->first();

            if (!$customer || !$customer->verifyOtp($request->otp)) {
                throw ValidationException::withMessages([
                    'otp' => ['The provided OTP is invalid or has expired.'],
                ]);
            }

            // Clear the OTP
            $customer->clearOtp();

            // Log the customer in
            Auth::guard('customer')->login($customer);

            return redirect()->intended(route('customer.dashboard'));
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('booking-welcome');
    }
}