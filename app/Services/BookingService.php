<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Service;
use App\Models\Shift;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class BookingService
{
    /**
     * Generate available time slots for a given service and date
     *
     * @param int $serviceId
     * @param string $date
     * @return array
     */
    public function generateTimeSlots($serviceId, $date)
    {
        $service = Service::findOrFail($serviceId);
        $dayOfWeek = Carbon::parse($date)->dayOfWeek;
        
        // Get all employees who work on this day
        $shifts = Shift::where('day_of_week', $dayOfWeek)
            ->with('user')
            ->get();
            
        $slots = [];
        
        foreach ($shifts as $shift) {
            $employee = $shift->user;
            $duration = $service->duration_minutes;
            
            $start = strtotime($shift->start_time);
            $end = strtotime($shift->end_time);
            
            // Get existing bookings for this employee on this date
            $existingBookings = Booking::where('employee_id', $employee->id)
                ->where('booking_date', $date)
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
                        'employee_id' => $employee->id,
                        'employee_name' => $employee->name,
                        'start_time' => $slotTime,
                        'end_time' => $slotEndTime,
                    ];
                }
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
        $lockKey = 'booking_' . $data['booking_date'] . '_' . $data['start_time'] . '_' . $data['employee_id'];
        
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
            ->with(['service', 'employee'])
            ->get();
    }
}