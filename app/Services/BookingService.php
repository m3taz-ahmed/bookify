<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class BookingService
{
    /**
     * Generate available time slots for a service on a specific date
     *
     * @param int $serviceId
     * @param string $date
     * @return array
     */
    public function generateTimeSlots($serviceId, $date)
    {
        $service = Service::findOrFail($serviceId);
        $duration = $service->duration_minutes;
        
        $slots = [];
        
        // For now, we'll generate slots for the entire day
        // In a real application, this might be configurable
        $startHour = 9; // 9 AM
        $endHour = 17;  // 5 PM
        
        $start = strtotime($startHour . ':00');
        $end = strtotime($endHour . ':00');
        
        // Get existing bookings for this date
        $existingBookings = Booking::where('booking_date', $date)
            ->get();
            
        // Generate slots
        for ($time = $start; $time < $end; $time += ($duration * 60)) {
            $slotTime = date('H:i', $time);
            $slotEndTime = date('H:i', $time + ($duration * 60));
            
            // Check if slot is available
            $isAvailable = true;
            foreach ($existingBookings as $booking) {
                if (($slotTime >= $booking->start_time && $slotTime < $booking->end_time) ||
                    ($slotEndTime > $booking->start_time && $slotEndTime <= $booking->end_time)) {
                    $isAvailable = false;
                    break;
                }
            }
            
            if ($isAvailable) {
                $slots[] = [
                    'start_time' => $slotTime,
                    'end_time' => $slotEndTime,
                ];
            }
        }
        
        return $slots;
    }
    
    /**
     * Create a booking with atomic locking
     *
     * @param array $data
     * @return Booking
     */
    public function createBookingWithLock(array $data)
    {
        $lockKey = 'booking_' . $data['booking_date'] . '_' . $data['start_time'];
        
        return Cache::lock($lockKey, 10)->get(function () use ($data) {
            return Booking::create($data);
        });
    }
    
    /**
     * Get bookings for a specific date
     *
     * @param string $date
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getBookingsForDate($date)
    {
        return Booking::where('booking_date', $date)
            ->with(['service'])
            ->get();
    }
}