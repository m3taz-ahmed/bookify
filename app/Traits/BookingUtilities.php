<?php

namespace App\Traits;

trait BookingUtilities
{
    /**
     * Generate a unique reference code for bookings
     *
     * @return string
     */
    public function generateReferenceCode()
    {
        return 'BKNG' . strtoupper(uniqid());
    }

    /**
     * Check if a time slot is available for booking
     *
     * @param int $employeeId
     * @param string $date
     * @param string $startTime
     * @param string $endTime
     * @return bool
     */
    public function isSlotAvailable($employeeId, $date, $startTime, $endTime)
    {
        // This would be implemented based on your specific business logic
        return true;
    }
}