<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Services\CapacityService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

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
        try {
            $service = Service::findOrFail($serviceId);
            // Use a fixed duration of 60 minutes since we removed duration_minutes from services table
            $duration = 60;
            
            // Validate duration to prevent infinite loop
            if ($duration <= 0 || $duration > 1440) { // 1440 minutes = 24 hours
                // Log::warning('Invalid duration for service: ' . $serviceId . ', duration: ' . $duration);
                return [];
            }
            
            $slots = [];
            
            // Get working hours for the date
            $bookingDate = Carbon::parse($date);
            $startTime = SiteSetting::getStartTime($bookingDate);
            $endTime = SiteSetting::getEndTime($bookingDate);
            
            // Check if it's a working day
            if (!$startTime || !$endTime) {
                // Log::info('Cannot generate slots for non-working day: ' . $date);
                return [];
            }
            
            $start = strtotime($startTime);
            $end = strtotime($endTime);
            
            // Validate time range
            if ($start >= $end) {
                // Log::warning('Invalid time range for service: ' . $serviceId . ', start: ' . $start . ', end: ' . $end);
                return [];
            }
            
            // Safety counter to prevent infinite loops
            $maxIterations = 100;
            $iterationCount = 0;
            
            // Generate slots without checking availability
            for ($time = $start; $time < $end && $iterationCount < $maxIterations; $time += ($duration * 60)) {
                $iterationCount++;
                
                // Validate time
                if ($time === false) {
                    // Log::warning('Invalid time value: ' . $time);
                    break;
                }
                
                $slotTime = date('H:i', $time);
                $slotEndTime = date('H:i', $time + ($duration * 60));
                
                // Validate end time
                if ($slotEndTime === false) {
                    // Log::warning('Invalid end time value: ' . $slotEndTime);
                    continue;
                }
                
                // Skip if slot end time exceeds business hours
                $endTimeObj = strtotime($slotEndTime);
                if ($endTimeObj === false || $endTimeObj > $end) {
                    // Log::warning('Slot end time exceeds business hours: ' . $slotEndTime);
                    continue;
                }
                
                // Always add the slot regardless of availability
                $slots[] = [
                    'start_time' => $slotTime,
                    'end_time' => $slotEndTime,
                ];
            }
            
            // Log::info('Generated ' . count($slots) . ' time slots for service: ' . $serviceId . ' on date: ' . $date);
            
            return $slots;
        } catch (\Exception $e) {
            // Log error and return empty array
            // Log::error('Error generating time slots: ' . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Create a booking with atomic locking and capacity validation
     *
     * @param array $data
     * @return Booking
     * @throws InvalidArgumentException
     */
    public function createBookingWithLock(array $data)
    {
        // Validate working day
        $bookingDate = Carbon::parse($data['booking_date']);
        if (!SiteSetting::isWorkingDay($bookingDate)) {
            throw new InvalidArgumentException('Cannot book on a non-working day.');
        }
        
        // Validate working hours
        $startTime = SiteSetting::getStartTime($bookingDate);
        $endTime = SiteSetting::getEndTime($bookingDate);
        
        if (!$startTime || !$endTime) {
            throw new InvalidArgumentException('Cannot book on a non-working day.');
        }
        
        $bookingStartTime = $data['start_time'];
        $bookingEndTime = $data['end_time'];
        
        // Validate that booking times are within working hours
        if ($bookingStartTime < $startTime || $bookingEndTime > $endTime) {
            throw new InvalidArgumentException('Booking times must be within working hours (' . $startTime . ' - ' . $endTime . ').');
        }
        
        // Validate that end time is after start time
        if ($bookingEndTime <= $bookingStartTime) {
            throw new InvalidArgumentException('End time must be after start time.');
        }
        
        // Validate capacity
        $numberOfPeople = $data['number_of_people'] ?? 1;
        if (CapacityService::wouldExceedCapacity($bookingDate, $numberOfPeople)) {
            throw new InvalidArgumentException('Adding this booking would exceed the daily capacity limit.');
        }
        
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