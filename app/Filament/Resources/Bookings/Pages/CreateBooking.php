<?php

namespace App\Filament\Resources\Bookings\Pages;

use App\Filament\Resources\Bookings\BookingResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class CreateBooking extends CreateRecord
{
    protected static string $resource = BookingResource::class;
    
    protected function handleRecordCreation(array $data): Model
    {
        try {
            // Use the booking service to create the booking with validation
            $bookingService = new \App\Services\BookingService();
            return $bookingService->createBookingWithLock($data);
        } catch (\InvalidArgumentException $e) {
            // Handle validation errors
            $this->notify('danger', $e->getMessage());
            throw $e; // Re-throw to prevent creation
        } catch (\Exception $e) {
            // Handle other errors
            // Log::error('Booking creation error: ' . $e->getMessage());
            $this->notify('danger', 'An error occurred while creating the booking.');
            throw $e; // Re-throw to prevent creation
        }
    }
}
