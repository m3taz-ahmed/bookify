<?php

namespace App\Livewire;

use App\Models\Service;
use App\Models\Booking;
use App\Services\BookingService;
use App\Http\Requests\StoreBookingRequest;
use Livewire\Component;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
    public $qrCode;
    
    protected $bookingService;

    public function boot(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

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
    
    public function updatedSelectedDate($value)
    {
        if ($value) {
            $this->loadShiftsAndSlots();
            // Only advance to step 3 if there are available slots
            if (!empty($this->availableSlots)) {
                $this->step = 3;
            }
        }
    }

    public function loadShiftsAndSlots()
    {
        $this->availableSlots = $this->bookingService->generateTimeSlots($this->selectedService, $this->selectedDate);
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
        // Create a temporary request to validate the data
        $request = new StoreBookingRequest();
        $request->merge([
            'customer_name' => $this->customerName,
            'customer_phone' => $this->customerPhone,
            'service_id' => $this->selectedService,
            'employee_id' => $this->selectedSlot['employee_id'],
            'booking_date' => $this->selectedDate,
            'start_time' => $this->selectedSlot['start_time'],
            'end_time' => collect($this->availableSlots)->firstWhere('start_time', $this->selectedSlot['start_time'])['end_time'],
        ]);
        
        // Validate the request
        $validator = validator($request->all(), $request->rules(), $request->messages());
        
        if ($validator->fails()) {
            $this->setErrorBag($validator->errors());
            return;
        }

        // Find the selected slot
        $slot = collect($this->availableSlots)->firstWhere('start_time', $this->selectedSlot['start_time']);
        
        $this->referenceCode = strtoupper(uniqid('BKNG'));
        
        try {
            $booking = $this->bookingService->createBookingWithLock([
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
            
            // Generate QR code
            $checkInUrl = route('check-in', $this->referenceCode);
            $this->qrCode = base64_encode(QrCode::format('png')->size(200)->generate($checkInUrl));
            
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