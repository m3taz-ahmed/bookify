<?php

namespace App\Livewire;

use App\Models\Service;
use App\Models\Shift;
use App\Models\Booking;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;

class CreateBooking extends Component
{
    public $step = 1;
    public $services;
    public $selectedService;
    public $selectedDate;
    public $shifts;
    public $availableSlots;
    public $selectedSlot;
    public $customerName;
    public $customerPhone;
    public $referenceCode;

    public function mount()
    {
        $this->services = Service::where('is_active', true)->get();
    }

    public function selectService($serviceId)
    {
        $this->selectedService = $serviceId;
        $this->step = 2;
    }

    public function selectDate($date)
    {
        $this->selectedDate = $date;
        $this->loadShiftsAndSlots();
        $this->step = 3;
    }

    public function loadShiftsAndSlots()
    {
        $dayOfWeek = date('w', strtotime($this->selectedDate));
        
        $this->shifts = Shift::where('day_of_week', $dayOfWeek)
            ->with('user')
            ->get();
            
        // Generate available slots based on shifts and filter out existing bookings
        $this->availableSlots = [];
        
        foreach ($this->shifts as $shift) {
            $service = Service::find($this->selectedService);
            $duration = $service->duration_minutes;
            
            $start = strtotime($shift->start_time);
            $end = strtotime($shift->end_time);
            
            // Check existing bookings for this date and employee
            $existingBookings = Booking::where('employee_id', $shift->user_id)
                ->where('booking_date', $this->selectedDate)
                ->get();
                
            // Generate slots
            for ($time = $start; $time < $end; $time += ($duration * 60)) {
                $slotTime = date('H:i', $time);
                $slotEndTime = date('H:i', $time + ($duration * 60));
                
                // Check if slot is available
                $isAvailable = true;
                foreach ($existingBookings as $booking) {
                    if (($slotTime >= $booking->start_time && $slotTime < $booking->end_time) ||
                        ($slotEndTime > $booking->start_time && $slotEndTime <= $booking->end_time)) {
                        $isAvailable = false;
                        break;
                    }
                }
                
                if ($isAvailable) {
                    $this->availableSlots[] = [
                        'employee_id' => $shift->user_id,
                        'employee_name' => $shift->user->name,
                        'start_time' => $slotTime,
                        'end_time' => $slotEndTime,
                    ];
                }
            }
        }
    }

    public function selectSlot($employeeId, $startTime)
    {
        $this->selectedSlot = [
            'employee_id' => $employeeId,
            'start_time' => $startTime
        ];
        $this->step = 4;
    }

    public function saveBooking()
    {
        $this->validate([
            'customerName' => 'required|string|max:255',
            'customerPhone' => 'required|string|max:20',
        ]);

        $service = Service::find($this->selectedService);
        
        // Find the selected slot
        $slot = collect($this->availableSlots)->firstWhere('start_time', $this->selectedSlot['start_time']);
        
        $this->referenceCode = strtoupper(uniqid('BKNG'));
        
        try {
            $booking = Booking::createWithLock([
                'reference_code' => $this->referenceCode,
                'customer_name' => $this->customerName,
                'customer_phone' => $this->customerPhone,
                'service_id' => $this->selectedService,
                'employee_id' => $this->selectedSlot['employee_id'],
                'booking_date' => $this->selectedDate,
                'start_time' => $this->selectedSlot['start_time'],
                'end_time' => $slot['end_time'],
                'status' => 'confirmed',
            ]);
            
            $this->step = 5; // Show success and QR code
        } catch (\Exception $e) {
            // Handle error
            $this->addError('booking', 'Failed to create booking. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.create-booking');
    }
}