<?php

namespace App\Livewire;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Notifications\BookingConfirmed;
use App\Services\CapacityService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class CreateBooking extends Component
{
    public $step = 1;
    public $selectedServiceId;
    public $selectedService;
    public $selectedDate;
    public $selectedTime;
    public $selectedDateWorkingHours = [];
    public $availableTimeSlots = [];
    public $fullName;
    public $phoneNumber;
    public $numberOfPeople = 1;
    public $paymentMethod;
    public $orderRef;
    public $booking;
    public $qrCode;
    public $referenceCode;

    protected $rules = [
        'selectedServiceId' => 'required|exists:services,id',
        'selectedDate' => 'required|date',
        'selectedTime' => 'required',
        'numberOfPeople' => 'required|integer|min:1|max:10',
        'paymentMethod' => 'required|in:cash,online',
    ];

    public function mount()
    {
        // Set default date to today in Saudi Arabia timezone
        $this->selectedDate = Carbon::today()->timezone('Asia/Riyadh')->format('Y-m-d');
    }
    
    public function selectService($serviceId)
    {
        $this->selectedServiceId = $serviceId;
        $this->selectedService = $serviceId;
        $this->goToNextStep();
    }
    
    public function selectNumberOfPeople($numberOfPeople)
    {
        $this->numberOfPeople = $numberOfPeople;
        $this->goToNextStep();
    }

    public function updatedSelectedServiceId($value)
    {
        // Reset date and time when service changes
        $this->selectedDate = null;
        $this->selectedTime = null;
        $this->availableTimeSlots = [];
    }

    public function updatedSelectedDate($value)
    {
        // Clear any previous date errors
        $this->resetValidation('selectedDate');
        
        // Reset working hours
        $this->selectedDateWorkingHours = [];
        
        if ($value) {
            // Reset selected time when date changes
            $this->selectedTime = null;
            
            try {
                // Validate working day and capacity
                $bookingDate = Carbon::parse($value)->timezone('Asia/Riyadh');
                
                // Get working hours for the selected day
                $this->selectedDateWorkingHours = SiteSetting::getTimeSlots($bookingDate);
                
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
            $timeSlots = SiteSetting::getTimeSlots($date);
            
            if (empty($timeSlots)) {
                $this->availableTimeSlots = [];
                return;
            }
            
            // Generate time slots (only 00 and 30 minutes)
            $allSlots = [];
            
            // Handle multiple time slots (shifts)
            foreach ($timeSlots as $slot) {
                if (isset($slot['start']) && isset($slot['end'])) {
                    $slots = $this->generateTimeSlots($slot['start'], $slot['end']);
                    $allSlots = array_merge($allSlots, $slots);
                }
            }
            
            // Filter out time slots that are already booked
            $filteredSlots = [];
            foreach ($allSlots as $time) {
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
        $startTime = Carbon::createFromTimeString($time)->timezone('Asia/Riyadh');
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
        $start = Carbon::createFromTimeString($startTime)->timezone('Asia/Riyadh');
        $end = Carbon::createFromTimeString($endTime)->timezone('Asia/Riyadh');
        
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
                $bookingDate = Carbon::parse($this->selectedDate)->timezone('Asia/Riyadh');
                
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
        
        // Create the booking
        $this->createBooking();
    }

    private function createBooking()
    {
        // Validate all inputs
        $this->validate();
        
        try {
            // For demo purposes, we'll use placeholder values for name and phone
            // In a real implementation, these would be collected from the user
            // or retrieved from authenticated user data
            $customerName = 'Customer';
            $customerPhone = '0000000000';
            
            // Create or find customer
            $customer = Customer::firstOrCreate(
                ['phone' => $customerPhone],
                ['name' => $customerName]
            );
            
            // Get the service
            $service = Service::find($this->selectedServiceId);
            
            // Parse date and time with Saudi Arabia timezone
            $bookingDate = Carbon::parse($this->selectedDate)->timezone('Asia/Riyadh');
            $startTime = Carbon::createFromTimeString($this->selectedTime)->timezone('Asia/Riyadh');
            $endTime = $startTime->copy()->addMinutes(30); // Assuming 30-min slots

            // Generate reference code
            $referenceCode = Booking::generateReferenceCode();
            
            // Create the booking
            $this->booking = Booking::create([
                'customer_id' => $customer->id,
                'service_id' => $this->selectedServiceId,
                'booking_date' => $bookingDate->format('Y-m-d'),
                'start_time' => $startTime->format('H:i:s'),
                'end_time' => $endTime->format('H:i:s'),
                'number_of_people' => $this->numberOfPeople,
                'status' => 'confirmed',
                'payment_method' => $this->paymentMethod,
                'reference_code' => $referenceCode,
            ]);
            
            // Set the reference code
            $this->referenceCode = $this->booking->reference_code;
            
            // Set the QR code
            $this->qrCode = $this->booking->qr_code;
            
            // Send confirmation notification
            $customer->notify(new BookingConfirmed($this->booking));
            
            if ($this->paymentMethod === 'online') {
                // For online payment, generate order reference
                $this->orderRef = 'ORD-' . strtoupper(uniqid());
                $this->booking->update(['order_ref' => $this->orderRef]);
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
            $startDate = Carbon::today()->timezone('Asia/Riyadh');
            $endDate = Carbon::today()->timezone('Asia/Riyadh')->addDays(30);
            $dateAvailability = \App\Services\DateAvailabilityService::getDateRangeStatus(
                $startDate->format('Y-m-d'), 
                $endDate->format('Y-m-d'),
                $this->numberOfPeople
            );
        }
        
        return view('livewire.create-booking', [
            'services' => Service::where('is_active', true)->get(),
            'dateAvailability' => $dateAvailability
        ]);
    }
}