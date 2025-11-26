<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckInController;
use App\Http\Controllers\Auth\CustomerAuthController;
use App\Http\Controllers\Auth\CustomerForgotPasswordController;
use App\Http\Controllers\Auth\CustomerResetPasswordController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\LanguageController;

// Root redirect to default locale
Route::get('/', function () {
    return redirect()->route('booking-welcome', ['locale' => config('app.locale', 'ar')]);
})->name('home');

// Locale-aware routes with SetLocale middleware
Route::group(['prefix' => '{locale}', 'where' => ['locale' => 'ar|en'], 'middleware' => 'web'], function () {
    // Home page
    Route::get('/', function () {
        return view('booking-welcome');
    })->name('booking-welcome');

    // Customer Authentication Routes
    Route::get('/customer/login', [CustomerAuthController::class, 'showLoginForm'])->name('customer.login');
    Route::post('/customer/login', [CustomerAuthController::class, 'login'])->name('customer.login.attempt');
    Route::get('/customer/register', [CustomerAuthController::class, 'showRegistrationForm'])->name('customer.register');
    Route::post('/customer/register', [CustomerAuthController::class, 'register'])->name('customer.register.attempt');
    Route::post('/customer/logout', [CustomerAuthController::class, 'logout'])->name('customer.logout');
    
    // Customer Password Reset Routes
    Route::get('/customer/password/reset', [CustomerForgotPasswordController::class, 'showLinkRequestForm'])->name('customer.password.request');
    Route::post('/customer/password/email', [CustomerForgotPasswordController::class, 'sendResetLinkEmail'])->name('customer.password.email');
    Route::get('/customer/password/reset/{token}', [CustomerResetPasswordController::class, 'showResetForm'])->name('customer.password.reset');
    Route::post('/customer/password/reset', [CustomerResetPasswordController::class, 'reset'])->name('customer.password.update');

    // Customer Dashboard and Bookings (protected by customer auth)
    Route::middleware('auth:customer')->group(function () {
        Route::get('/customer/dashboard', [DashboardController::class, 'index'])->name('customer.dashboard');
        Route::get('/customer/profile', [CustomerController::class, 'profile'])->name('customer.profile');
        Route::get('/customer/profile/edit', [CustomerController::class, 'editProfile'])->name('customer.profile.edit');
        Route::put('/customer/profile', [CustomerController::class, 'updateProfile'])->name('customer.profile.update');
        Route::get('/customer/bookings', [CustomerController::class, 'bookings'])->name('customer.bookings');
        Route::get('/customer/bookings/create', [CustomerController::class, 'createBooking'])->name('customer.bookings.create');
        Route::post('/customer/bookings', [CustomerController::class, 'storeBooking'])->name('customer.bookings.store');
        Route::get('/customer/bookings/{booking}/edit', [CustomerController::class, 'editBooking'])->name('customer.bookings.edit');
        Route::put('/customer/bookings/{booking}', [CustomerController::class, 'updateBooking'])->name('customer.bookings.update');
        Route::delete('/customer/bookings/{booking}', [CustomerController::class, 'cancelBooking'])->name('customer.bookings.cancel');
        
        // Test route
        Route::get('/customer/bookings/test', function () {
            $services = \App\Models\Service::where('is_active', true)->get();
            $employees = \App\Models\User::whereHas('roles', function ($query) {
                $query->where('name', 'employee');
            })->get();
            return view('test-booking', compact('services', 'employees'));
        })->name('customer.bookings.test');
    });
    
    Route::get('/check-in/{reference}', [CheckInController::class, 'checkIn'])->name('check-in-api')->middleware('auth:customer');
    Route::get('/check-in-page/{reference}', [CheckInController::class, 'showCheckInPage'])->name('check-in')->middleware('auth:customer');
    Route::get('/book', function () {
        return view('bookings.create');
    });
});

// Language switcher route
Route::get('/lang/{locale}', [LanguageController::class, 'switch'])->name('lang.switch')->middleware('web');

// Language test route
Route::get('/language-test', function () {
    return view('language-test');
})->name('language.test')->middleware('web');

// Debug language route
Route::get('/debug-language', function (\Illuminate\Http\Request $request) {
    // Make sure session is started
    if ($request->hasSession() && !$request->session()->isStarted()) {
        $request->session()->start();
    }
    
    // Log session data for debugging
    \Illuminate\Support\Facades\Log::info('Debug language route called', [
        'session_id' => $request->hasSession() ? $request->session()->getId() : null,
        'session_started' => $request->hasSession() ? $request->session()->isStarted() : false,
        'session_locale' => $request->session()->get('locale'),
        'session_all_data' => $request->hasSession() ? $request->session()->all() : null
    ]);
    
    return response()->json([
        'locale' => app()->getLocale(),
        'session_locale' => $request->session()->get('locale'),
        'config_locale' => config('app.locale'),
        'session_driver' => config('session.driver'),
        'session_started' => $request->hasSession() ? $request->session()->isStarted() : false,
        'session_id' => $request->hasSession() ? $request->session()->getId() : null,
        'languages' => ['ar', 'en']
    ]);
})->name('debug.language')->middleware('web');

// Test authentication route
Route::get('/test-auth', function () {
    return view('test-auth');
})->name('test.auth')->middleware('web');