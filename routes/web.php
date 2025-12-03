<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckInController;
use App\Http\Controllers\Auth\CustomerPhoneAuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\BookingLinkController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SitemapController;

// Root redirect to booking welcome page
Route::get('/', function () {
    return redirect()->route('booking-welcome');
})->name('home')->middleware('web');

// Home page
Route::get('/welcome', function () {
    return view('booking-welcome');
})->name('booking-welcome')->middleware('web');

// Customer Phone Authentication Routes (ONLY method now)
Route::get('/customer/login', [CustomerPhoneAuthController::class, 'showPhoneForm'])->name('customer.login')->middleware('web');
Route::post('/customer/login', [CustomerPhoneAuthController::class, 'sendOtp'])->name('customer.login.attempt')->middleware('web');
Route::post('/customer/verify-otp', [CustomerPhoneAuthController::class, 'verifyOtp'])->name('customer.verify-otp')->middleware('web');
Route::post('/customer/logout', [CustomerPhoneAuthController::class, 'logout'])->name('customer.logout')->middleware('web');

// Customer Registration
Route::get('/customer/register', [CustomerPhoneAuthController::class, 'showRegistrationForm'])->name('customer.register')->middleware('web');
Route::post('/customer/register', [CustomerPhoneAuthController::class, 'register'])->name('customer.register.attempt')->middleware('web');

// Customer Dashboard and Bookings (protected by customer auth)
Route::middleware(['auth:customer', 'web'])->group(function () {
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

Route::get('/check-in/{reference}', [CheckInController::class, 'checkIn'])->name('check-in-api')->middleware(['auth:customer', 'web']);
Route::get('/check-in-page/{reference}', [CheckInController::class, 'showCheckInPage'])->name('check-in')->middleware(['auth:customer', 'web']);
Route::get('/book', function () {
    return view('bookings.create');
})->middleware('web');

// Public signed booking link (customer + reference)
Route::get('/booking/view/{customer}/{reference}', [BookingLinkController::class, 'show'])
    ->name('booking.link')
    ->middleware(['web']);

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

// Sitemap
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Static pages routes
Route::get('/{slug}', [PageController::class, 'show'])
    ->where('slug', '^(?!admin|customer|api|filament|lang|check-in|book|welcome|test|sitemap).*')
    ->name('pages.show')
    ->middleware('web');