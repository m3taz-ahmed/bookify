<?php

namespace App\Livewire;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Services\BookingService;
use App\Services\CapacityService;
use App\Services\DateAvailabilityService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class CreateBooking extends Component
{
    public $step = 1;
    public $services;
    public $selectedService;
    public $numberOfPeople = 1;
    public $selectedDate;
    public $selectedTime;
    public $referenceCode;
    public $qrCode;
    public $paymentMethod;
    public $orderRef;
    public $availableTimeSlots = [];
    
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

    public function selectNumberOfPeople($number)
    {
        $this->numberOfPeople = $number;
        $this->step = 3;
    }

    public function updatedSelectedDate($value)
    {
        // Clear any previous date errors
        $this->resetValidation('selectedDate');
        
        if ($value) {
            // Reset selected time when date changes
            $this->selectedTime = null;
            
            try {
                // Validate working day and capacity
                $bookingDate = Carbon::parse($value);
                
                // Check if it's a working day
                if (!SiteSetting::isWorkingDay($bookingDate)) {
                    $this->addError('selectedDate', 'Cannot book on a non-working day.');
                    $this->availableTimeSlots = [];
                    return;
                }
                
                // Check capacity
                if (CapacityService::wouldExceedCapacity($bookingDate, $this->numberOfPeople)) {
                    $this->addError('selectedDate', 'Adding this booking would exceed the daily capacity limit.');
                    $this->availableTimeSlots = [];
                    return;
                }
                
                // Get available time slots for the selected date
                $this->loadAvailableTimeSlots($bookingDate);
            } catch (\Exception $e) {
                // Handle any parsing errors
                $this->addError('selectedDate', 'Invalid date selected.');
                $this->availableTimeSlots = [];
                $this->selectedTime = null;
            }
        } else {
            $this->availableTimeSlots = [];
            $this->selectedTime = null;
        }
    }
    
    public function setSelectedDate($date)
    {
        $this->selectedDate = $date;
        $this->updatedSelectedDate($date);
    }
    
    private function loadAvailableTimeSlots($date)
    {
        try {
            // Get working hours for the selected day
            $dayOfWeek = strtolower($date->format('l'));
            $workingHours = SiteSetting::getWorkingHours($dayOfWeek);
            
            if (!$workingHours) {
                $this->availableTimeSlots = [];
                return;
            }
            
            // Generate time slots (only 00 and 30 minutes)
            $timeSlots = [];
            
            // Handle both old format (single time slot) and new format (multiple time slots)
            if (isset($workingHours['start']) && isset($workingHours['end'])) {
                // Old format - single time slot
                $slots = $this->generateTimeSlots($workingHours['start'], $workingHours['end']);
                $timeSlots = array_merge($timeSlots, $slots);
            } elseif (is_array($workingHours)) {
                // New format - multiple time slots (shifts)
                foreach ($workingHours as $slot) {
                    if (isset($slot['start']) && isset($slot['end'])) {
                        $slots = $this->generateTimeSlots($slot['start'], $slot['end']);
                        $timeSlots = array_merge($timeSlots, $slots);
                    }
                }
            }
            
            // Filter out time slots that are already booked
            $filteredSlots = [];
            foreach ($timeSlots as $time) {
                if (!$this->isTimeSlotBooked($date, $time)) {
                    $filteredSlots[] = $time;
                }
            }
            
            // Sort the time slots to ensure they're in chronological order
            sort($filteredSlots);
            
            $this->availableTimeSlots = $filteredSlots;
        } catch (\Exception $e) {
            // Handle any errors gracefully
            $this->availableTimeSlots = [];
            // Log the error if needed
            Log::error('Error loading available time slots: ' . $e->getMessage());
        }
    }
    
    private function isTimeSlotBooked($date, $time)
    {
        // Check if there are any bookings for this date and time
        $startTime = Carbon::createFromTimeString($time);
        $endTime = $startTime->copy()->addMinutes(30); // Assuming 30-min slots
        
        $existingBookings = Booking::where('booking_date', $date->format('Y-m-d'))
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime->format('H:i:s'), $endTime->format('H:i:s')])
                    ->orWhereBetween('end_time', [$startTime->format('H:i:s'), $endTime->format('H:i:s')])
                    ->orWhere(function ($q) use ($startTime, $endTime) {
                        $q->where('start_time', '<=', $startTime->format('H:i:s'))
                            ->where('end_time', '>=', $endTime->format('H:i:s'));
                    });
            })
            ->count();
            
        return $existingBookings > 0;
    }
    
    private function generateTimeSlots($startTime, $endTime)
    {
        $slots = [];
        $start = Carbon::createFromTimeString($startTime);
        $end = Carbon::createFromTimeString($endTime);
        
        // Generate slots at 30-minute intervals
        while ($start->lt($end)) {
            $timeString = $start->format('H:i');
            // Only include 00 and 30 minutes
            if ($start->minute == 0 || $start->minute == 30) {
                $slots[] = $timeString;
            }
            $start->addMinutes(30);
        }
        
        return $slots;
    }

    public function selectTime($time)
    {
        $this->selectedTime = $time;
        // Clear any previous date errors when a time is selected
        $this->resetValidation('selectedDate');
    }
    
    public function handleDateSelection()
    {
        // Clear any previous date errors
        $this->resetValidation('selectedDate');
        
        if ($this->selectedDate && $this->selectedTime) {
            // Validate working day and capacity
            try {
                $bookingDate = Carbon::parse($this->selectedDate);
                
                // Check if it's a working day
                if (!SiteSetting::isWorkingDay($bookingDate)) {
                    $this->addError('selectedDate', 'Cannot book on a non-working day.');
                    return;
                }
                
                // Check capacity
                if (CapacityService::wouldExceedCapacity($bookingDate, $this->numberOfPeople)) {
                    $this->addError('selectedDate', 'Adding this booking would exceed the daily capacity limit.');
                    return;
                }
                
                // Proceed to payment method
                $this->step = 4;
            } catch (\Exception $e) {
                $this->addError('selectedDate', 'Invalid date selected.');
                return;
            }
        }
    }
    
    public function goToNextStep()
    {
        if ($this->step < 5) {
            $this->step++;
        }
    }
    
    public function goToPreviousStep()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    public function selectPaymentMethod($method)
    {
        // Clear any previous booking errors
        $this->resetValidation('booking');
        
        // Validate that the payment method is either 'cash' or 'online'
        if (!in_array($method, ['cash', 'online'])) {
            $this->addError('paymentMethod', 'Invalid payment method selected.');
            return;
        }
        
        $this->paymentMethod = $method;
        // Automatically save the booking when payment method is selected
        $this->saveBooking();
    }

    public function saveBooking()
    {
        // Validate that the payment method is either 'cash' or 'online'
        if (!in_array($this->paymentMethod, ['cash', 'online'])) {
            $this->addError('paymentMethod', 'Invalid payment method selected.');
            return;
        }
        
        // Validate required fields
        if (!$this->selectedService || !$this->selectedDate || !$this->selectedTime || !$this->numberOfPeople) {
            $this->addError('booking', 'Missing required booking information.');
            return;
        }
        
        // Check if customer is authenticated
        if (!Auth::guard('customer')->check()) {
            $this->addError('booking', 'You must be logged in to create a booking.');
            return;
        }
        
        try {
            // Get the service to calculate duration
            $service = Service::findOrFail($this->selectedService);
            $duration = $service->duration_minutes ?? 60; // Default to 60 minutes if not set
            
            // Calculate end time
            $startTime = Carbon::createFromTimeString($this->selectedTime);
            $endTime = $startTime->copy()->addMinutes($duration);
            
            $this->referenceCode = Booking::generateReferenceCode();
            
            // Prepare booking data - only use customer_id since customer is logged in
            $bookingData = [
                'reference_code' => $this->referenceCode,
                'customer_id' => Auth::guard('customer')->id(),
                'service_id' => $this->selectedService,
                'booking_date' => $this->selectedDate,
                'start_time' => $this->selectedTime,
                'end_time' => $endTime->format('H:i:s'),
                'status' => ($this->paymentMethod === 'cash') ? 'confirmed' : 'pending',
                'number_of_people' => $this->numberOfPeople,
                'payment_method' => $this->paymentMethod,
                'is_paid' => ($this->paymentMethod === 'cash') ? false : null, // For online payments, we'll set this after payment confirmation
            ];
            
            $booking = $this->bookingService->createBookingWithLock($bookingData);
            
            // The QR code is already generated by the model, so we just need to get it
            $this->qrCode = $booking->qr_code;
            
            // If payment method is cash, mark as confirmed
            if ($this->paymentMethod === 'cash') {
                $booking->update(['status' => 'confirmed']);
            } else {
                // For online payment, generate order reference
                $this->orderRef = 'ORD-' . strtoupper(uniqid());
                $booking->update(['order_ref' => $this->orderRef]);
            }
            
            $this->step = 5; // Show success and QR code
        } catch (\Exception $e) {
            // Handle error
            $this->addError('booking', 'Failed to create booking. Please try again. Error: ' . $e->getMessage());
        }
    }

    public function render()
    {
        // Get date availability for the next 30 days
        $dateAvailability = [];
        if ($this->step === 3) {
            $startDate = Carbon::today();
            $endDate = Carbon::today()->addDays(30);
            $dateAvailability = DateAvailabilityService::getDateRangeStatus(
                $startDate->format('Y-m-d'), 
                $endDate->format('Y-m-d'),
                $this->numberOfPeople
            );
        }
        
        return view('livewire.create-booking', [
            'dateAvailability' => $dateAvailability
        ]);
    }
}