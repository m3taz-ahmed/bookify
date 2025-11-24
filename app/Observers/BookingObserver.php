<?php

namespace App\Observers;

use App\Models\Booking;
use App\Notifications\BookingConfirmed;
use App\Notifications\BookingCancelled;
use Illuminate\Support\Facades\Log;


class BookingObserver
{
    /**
     * Handle the Booking "created" event.
     */
    public function created(Booking $booking): void
    {
        // Send confirmation notification when booking is created
        if ($booking->status === 'confirmed') {
            // In a real application, you would send this to the customer's email
            // For now, we'll just log it
            Log::info('Booking confirmed: ' . $booking->reference_code);
        }
    }

    /**
     * Handle the Booking "updated" event.
     */
    public function updated(Booking $booking): void
    {
        // Check if status changed
        if ($booking->isDirty('status')) {
            $oldStatus = $booking->getOriginal('status');
            $newStatus = $booking->status;
            
            // Send notification when booking is confirmed
            if ($oldStatus !== 'confirmed' && $newStatus === 'confirmed') {
                // In a real application, you would send this to the customer's email
                Log::info('Booking confirmed: ' . $booking->reference_code);
            }
            
            // Send notification when booking is cancelled
            if ($oldStatus !== 'cancelled' && $newStatus === 'cancelled') {
                // In a real application, you would send this to the customer's email
                Log::info('Booking cancelled: ' . $booking->reference_code);
            }
        }
    }

    /**
     * Handle the Booking "deleted" event.
     */
    public function deleted(Booking $booking): void
    {
        //
    }

    /**
     * Handle the Booking "restored" event.
     */
    public function restored(Booking $booking): void
    {
        //
    }

    /**
     * Handle the Booking "force deleted" event.
     */
    public function forceDeleted(Booking $booking): void
    {
        //
    }
}