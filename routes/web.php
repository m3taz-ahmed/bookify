<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckInController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/check-in/{reference}', [CheckInController::class, 'checkIn']);
Route::get('/book', function () {
    return view('bookings.create');
});