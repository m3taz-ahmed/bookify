<?php

namespace App\Filament\Resources\Bookings\Components;

use App\Models\SiteSetting;
use Carbon\Carbon;
use Closure;
use Filament\Forms\Components\DatePicker;
use Illuminate\Contracts\Support\Htmlable;

class WorkingDaysDatePicker extends DatePicker
{
    protected function setUp(): void
    {
        parent::setUp();

        // Disable non-working days
        $this->disabledDates(function () {
            $disabledDates = [];
            
            // Get the next 30 days to check
            $startDate = Carbon::today();
            $endDate = Carbon::today()->addDays(30);
            
            $currentDate = $startDate->copy();
            while ($currentDate->lte($endDate)) {
                // Check if it's a working day
                if (!SiteSetting::isWorkingDay($currentDate)) {
                    $disabledDates[] = $currentDate->format('Y-m-d');
                }
                
                $currentDate->addDay();
            }
            
            return $disabledDates;
        });
    }
}