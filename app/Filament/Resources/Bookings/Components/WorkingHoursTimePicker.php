<?php

namespace App\Filament\Resources\Bookings\Components;

use App\Models\SiteSetting;
use Carbon\Carbon;
use Closure;
use Filament\Forms\Components\Select;
use Illuminate\Contracts\Support\Htmlable;

class WorkingHoursTimePicker extends Select
{
    protected string | Closure | null $dateField = null;
    
    protected string | Closure | null $startTimeField = null;

    public function dateField(string | Closure $dateField): static
    {
        $this->dateField = $dateField;

        return $this;
    }
    
    public function startTimeField(string | Closure $startTimeField): static
    {
        $this->startTimeField = $startTimeField;

        return $this;
    }

    public function getDateField(): string | Closure | null
    {
        return $this->dateField;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->options(function (callable $get) {
            // Get the date from the form
            $dateField = $this->evaluate($this->dateField);
            
            if (!$dateField) {
                return [];
            }
            
            // Get the actual value of the date field from the form state
            $dateValue = $get($dateField);
            
            if (!$dateValue) {
                return [];
            }
            
            try {
                $date = Carbon::parse($dateValue);
                
                // Check if it's a working day
                if (!SiteSetting::isWorkingDay($date)) {
                    return [];
                }
                
                // Get all time slots for the day
                $timeSlots = SiteSetting::getTimeSlots($date);
                
                if (empty($timeSlots)) {
                    return [];
                }
                
                $options = [];
                
                // Process each time slot
                foreach ($timeSlots as $slot) {
                    $workingStartTime = $slot['start'] ?? null;
                    $workingEndTime = $slot['end'] ?? null;
                    
                    if (!$workingStartTime || !$workingEndTime) {
                        continue;
                    }
                    
                    $start = strtotime($workingStartTime);
                    $end = strtotime($workingEndTime);
                    
                    // Generate time options in 30-minute intervals for this slot
                    for ($time = $start; $time <= $end; $time += 1800) { // 1800 seconds = 30 minutes
                        $timeString = date('H:i', $time);
                        $options[$timeString] = $timeString;
                    }
                }
                
                // Sort the options
                ksort($options);
                
                // If this is an end time field and we have a start time field, 
                // filter options to only show times after the start time
                if ($this->startTimeField) {
                    $startTimeField = $this->evaluate($this->startTimeField);
                    $startTimeValue = $get($startTimeField);
                    
                    if ($startTimeValue) {
                        $minTime = strtotime($startTimeValue) + 1800; // Add 30 minutes
                        $filteredOptions = [];
                        foreach ($options as $time => $label) {
                            if (strtotime($time) >= $minTime) {
                                $filteredOptions[$time] = $label;
                            }
                        }
                        $options = $filteredOptions;
                    }
                }
                
                return $options;
            } catch (\Exception $e) {
                // Return empty options if date parsing fails
                return [];
            }
        });
    }
}