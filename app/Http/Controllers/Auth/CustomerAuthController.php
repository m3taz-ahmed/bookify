<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class CustomerAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.customer.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('customer')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            
            $locale = $request->route('locale') ?? app()->getLocale();
            return redirect()->intended(route('customer.dashboard', ['locale' => $locale]));
        }

        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
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
            // Email and password are optional now
            'email' => null,
            'password' => null,
        ]);

        // For backward compatibility, we'll still log them in
        Auth::guard('customer')->login($customer);

        $locale = $request->route('locale') ?? app()->getLocale();
        return redirect()->route('customer.dashboard', ['locale' => $locale]);
    }

    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $locale = $request->route('locale') ?? app()->getLocale();
        return redirect()->route('booking-welcome', ['locale' => $locale]);
    }
}