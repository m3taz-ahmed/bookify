<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookingController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->middleware('throttle:60,1')->group(function () {
    Route::apiResource('bookings', BookingController::class);
    Route::get('bookings/slots/available', [BookingController::class, 'getAvailableSlots']);
});