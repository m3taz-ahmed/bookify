<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

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

        $customer = Customer::create([
            'name' => $request->name,
            'phone' => $request->phone,
            // Email and password are not needed
            'email' => null,
            'password' => null,
        ]);

        // Automatically log them in after registration
        Auth::guard('customer')->login($customer);

        return redirect()->route('customer.dashboard');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|exists:customers,phone',
        ]);

        $customer = Customer::where('phone', $request->phone)->first();
        
        // Generate OTP (will be 123456 as default)
        $otp = $customer->generateOtp();
        
        // TODO: In the future, integrate with SMS provider here
        // For now, we'll just display the OTP in the view for testing
        // In a real implementation, you would send SMS here:
        // SmsProvider::send($customer->phone, "Your OTP code is: $otp");
        
        return view('auth.customer.verify-otp', compact('customer'));
    }

    public function verifyOtp(Request $request)
    {
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

    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('booking-welcome');
    }
}