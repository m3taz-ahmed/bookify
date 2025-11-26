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
}