<?php

namespace App\Services;

use App\Models\SiteSetting;
use App\Services\CapacityService;
use Carbon\Carbon;

class DateAvailabilityService
{
    /**
     * Get the availability status of a date
     *
     * @param string $dateString
     * @param int $numberOfPeople
     * @return string 'available', 'non-working', or 'fully-booked'
     */
    public static function getDateStatus($dateString, $numberOfPeople = 1)
    {
        $date = Carbon::parse($dateString);
        
        // Check if it's a working day
        if (!SiteSetting::isWorkingDay($date)) {
            return 'non-working';
        }
        
        // Check capacity
        if (CapacityService::wouldExceedCapacity($date, $numberOfPeople)) {
            return 'fully-booked';
        }
        
        return 'available';
    }
    
    /**
     * Get availability status for a range of dates
     *
     * @param string $startDate
     * @param string $endDate
     * @param int $numberOfPeople
     * @return array
     */
    public static function getDateRangeStatus($startDate, $endDate, $numberOfPeople = 1)
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        $statuses = [];
        
        $current = $start->copy();
        while ($current->lte($end)) {
            $dateString = $current->format('Y-m-d');
            $statuses[$dateString] = self::getDateStatus($dateString, $numberOfPeople);
            $current->addDay();
        }
        
        return $statuses;
    }
}