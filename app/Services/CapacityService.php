<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\SiteSetting;
use Carbon\Carbon;

class CapacityService
{
    /**
     * Get the total number of people booked for a specific date
     *
     * @param Carbon $date
     * @return int
     */
    public static function getTotalPeopleForDate($date)
    {
        $bookings = Booking::where('booking_date', $date->format('Y-m-d'))
            ->where('status', '!=', 'cancelled')
            ->get();

        $totalPeople = 0;
        foreach ($bookings as $booking) {
            $totalPeople += $booking->number_of_people;
        }

        return $totalPeople;
    }

    /**
     * Check if adding a certain number of people would exceed capacity
     *
     * @param Carbon $date
     * @param int $numberOfPeople
     * @return bool
     */
    public static function wouldExceedCapacity($date, $numberOfPeople)
    {
        $maxCapacity = SiteSetting::getMaxCapacity();
        $currentPeople = self::getTotalPeopleForDate($date);
        
        return ($currentPeople + $numberOfPeople) > $maxCapacity;
    }

    /**
     * Get the capacity percentage for a date
     *
     * @param Carbon $date
     * @return float
     */
    public static function getCapacityPercentage($date)
    {
        $maxCapacity = SiteSetting::getMaxCapacity();
        $currentPeople = self::getTotalPeopleForDate($date);
        
        if ($maxCapacity <= 0) {
            return 0;
        }
        
        return ($currentPeople / $maxCapacity) * 100;
    }

    /**
     * Get the capacity status color for a date
     *
     * @param Carbon $date
     * @return string
     */
    public static function getCapacityStatusColor($date)
    {
        // Check if it's a working day
        if (!SiteSetting::isWorkingDay($date)) {
            return 'gray'; // Non-working day
        }

        $percentage = self::getCapacityPercentage($date);

        if ($percentage >= 100) {
            return 'red'; // Fully booked
        } elseif ($percentage >= 50) {
            return 'yellow'; // More than half full
        } else {
            return 'green'; // Less than half full
        }
    }
}