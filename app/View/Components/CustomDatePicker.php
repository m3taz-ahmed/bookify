<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\SiteSetting;
use App\Services\CapacityService;
use Carbon\Carbon;

class CustomDatePicker extends Component
{
    public $selectedDate;
    public $minDate;
    public $maxDate;
    
    public function __construct($selectedDate = null, $minDate = null, $maxDate = null)
    {
        $this->selectedDate = $selectedDate;
        $this->minDate = $minDate ?? date('Y-m-d');
        $this->maxDate = $maxDate ?? date('Y-m-d', strtotime('+3 months'));
    }

    public function render()
    {
        return view('components.custom-date-picker');
    }
    
    public function getDateStatus($date)
    {
        $carbonDate = Carbon::parse($date);
        
        // Check if it's a working day
        if (!SiteSetting::isWorkingDay($carbonDate)) {
            return 'non-working';
        }
        
        // Check capacity
        if (CapacityService::wouldExceedCapacity($carbonDate, 1)) { // Using 1 as default for checking
            return 'fully-booked';
        }
        
        return 'available';
    }
}