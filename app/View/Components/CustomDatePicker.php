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
        $this->minDate = $minDate ?? Carbon::today()->timezone('Asia/Riyadh')->format('Y-m-d');
        $this->maxDate = $maxDate ?? Carbon::today()->timezone('Asia/Riyadh')->addMonths(3)->format('Y-m-d');
    }

    public function render()
    {
        return view('components.custom-date-picker');
    }
    
    public function getDateStatus($date)
    {
        $carbonDate = Carbon::parse($date)->timezone('Asia/Riyadh');
        
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