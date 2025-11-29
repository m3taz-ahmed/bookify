<?php

namespace App\Services;

use App\Models\SiteSetting;
use Carbon\Carbon;

class NextAvailableSlotService
{
    /**
     * Get the next available time slot based on working hours
     *
     * @return array|null
     */
    public static function getNextAvailableSlot()
    {
        try {
            // Get today's date in Saudi Arabia timezone
            $today = Carbon::today()->timezone('Asia/Riyadh');
            
            // Check if today is a working day
            if (!SiteSetting::isWorkingDay($today)) {
                // If today is not a working day, check tomorrow
                $tomorrow = $today->copy()->addDay();
                if (SiteSetting::isWorkingDay($tomorrow)) {
                    // Get the start time for tomorrow
                    $startTime = SiteSetting::getStartTime($tomorrow);
                    if ($startTime) {
                        return [
                            'is_available_now' => false,
                            'date' => $tomorrow->format('Y-m-d'),
                            'time' => self::formatTime($startTime),
                            'day' => $tomorrow->format('l')
                        ];
                    }
                }
                return null;
            }
            
            // Today is a working day, check current time
            $now = Carbon::now()->timezone('Asia/Riyadh');
            $currentTime = $now->format('H:i');
            
            // Get today's working hours
            $workingHours = SiteSetting::getTimeSlots($today);
            
            if (empty($workingHours)) {
                return null;
            }
            
            // Check if we're currently within working hours
            foreach ($workingHours as $slot) {
                $start = $slot['start'] ?? null;
                $end = $slot['end'] ?? null;
                
                if (!$start || !$end) {
                    continue;
                }
                
                // Check if current time is before the end of this slot
                if ($currentTime < $end) {
                    // If current time is before the start of this slot, it's the next available
                    if ($currentTime < $start) {
                        return [
                            'is_available_now' => false,
                            'date' => $today->format('Y-m-d'),
                            'time' => self::formatTime($start),
                            'day' => $today->format('l')
                        ];
                    }
                    // Otherwise, we're currently within this slot, so it's available now
                    else {
                        return [
                            'is_available_now' => true,
                            'date' => $today->format('Y-m-d'),
                            'time' => null,
                            'day' => $today->format('l')
                        ];
                    }
                }
            }
            
            // If we've passed all working hours for today, check tomorrow
            $tomorrow = $today->copy()->addDay();
            if (SiteSetting::isWorkingDay($tomorrow)) {
                // Get the start time for tomorrow
                $startTime = SiteSetting::getStartTime($tomorrow);
                if ($startTime) {
                    return [
                        'is_available_now' => false,
                        'date' => $tomorrow->format('Y-m-d'),
                        'time' => self::formatTime($startTime),
                        'day' => $tomorrow->format('l')
                    ];
                }
            }
            
            return null;
        } catch (\Exception $e) {
            // Log error if needed
            // \Log::error('Error finding next available slot: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Format time to 12-hour format with AM/PM
     *
     * @param string $time
     * @return string
     */
    private static function formatTime($time)
    {
        try {
            $carbonTime = Carbon::createFromFormat('H:i', $time)->timezone('Asia/Riyadh');
            return $carbonTime->format('g:i A');
        } catch (\Exception $e) {
            return $time;
        }
    }
}