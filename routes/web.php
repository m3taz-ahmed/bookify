<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckInController;
use App\Http\Controllers\Auth\CustomerPhoneAuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\LanguageController;

// Root redirect to booking welcome page
Route::get('/', function () {
    return redirect()->route('booking-welcome');
})->name('home');

// Home page
Route::get('/welcome', function () {
    return view('booking-welcome');
})->name('booking-welcome');

// Customer Phone Authentication Routes (ONLY method now)
Route::get('/customer/login', [CustomerPhoneAuthController::class, 'showPhoneForm'])->name('customer.login');
Route::post('/customer/login', [CustomerPhoneAuthController::class, 'sendOtp'])->name('customer.login.attempt');
Route::post('/customer/verify-otp', [CustomerPhoneAuthController::class, 'verifyOtp'])->name('customer.verify-otp');
Route::post('/customer/logout', [CustomerPhoneAuthController::class, 'logout'])->name('customer.logout');

// Customer Registration
Route::get('/customer/register', [CustomerPhoneAuthController::class, 'showRegistrationForm'])->name('customer.register');
Route::post('/customer/register', [CustomerPhoneAuthController::class, 'register'])->name('customer.register.attempt');

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

// Language switcher route
Route::get('/lang/{locale}', [LanguageController::class, 'switch'])->name('lang.switch')->middleware('web');

// Language test route
Route::get('/language-test', function () {
    return view('language-test');
})->name('language.test')->middleware('web');

// Filament translation test route
Route::get('/filament-translation-test', function () {
    return view('filament-translation-test');
})->name('filament.translation.test')->middleware('web');

// Test route for checking translations
Route::get('/test-translations', function () {
    return response()->json([
        'app_locale' => app()->getLocale(),
        'session_locale' => session('locale'),
    ]);
})->name('test.translations')->middleware('web');

// Static pages routes
Route::get('/{slug}', function ($slug) {
    $page = \App\Models\Page::where('slug', $slug)->active()->first();
    
    if (!$page) {
        abort(404);
    }
    
    return view('pages.show', compact('page'));
})->where('slug', '^(?!admin|customer|api|filament|lang|check-in|book|welcome|test).*')->name('pages.show');