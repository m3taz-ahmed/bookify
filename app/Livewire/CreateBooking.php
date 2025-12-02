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
        // Don't set default date - let customer choose
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
                // We allow multiple bookings per slot, so we don't check isTimeSlotBooked anymore
                // unless we want to implement a per-slot capacity later.
                // if (!$this->isTimeSlotBooked($date, $time)) {
                    $filteredSlots[] = $time;
                // }
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
        // Parse time as Riyadh time directly
        $startTime = Carbon::createFromFormat('H:i', $time, 'Asia/Riyadh');
        // Set the date part to match the booking date
        $startTime->setDate($date->year, $date->month, $date->day);
        
        $endTime = $startTime->copy()->addMinutes(30); // Assuming 30-min slots
        
        $query = Booking::where('booking_date', $date->format('Y-m-d'))
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($startTime, $endTime) {
                // We compare times as strings to avoid timezone confusion in DB query
                $sTime = $startTime->format('H:i:s');
                $eTime = $endTime->format('H:i:s');
                
                $query->where('start_time', '>=', $sTime)
                    ->where('start_time', '<', $eTime);
            });
            
        $count = $query->count();
        
        if ($count > 0) {
            $conflicts = $query->get(['id', 'start_time', 'status']);
            Log::info('Slot Booked Conflict', [
                'slot' => $time,
                'conflicts' => $conflicts->toArray()
            ]);
        }
            
        return $count > 0;
    }
    
    private function generateTimeSlots($startTime, $endTime)
    {
        Log::info('Generating Time Slots', ['start_in' => $startTime, 'end_in' => $endTime]);
        
        $slots = [];
        // Parse the time strings explicitly as Riyadh time to avoid UTC conversion shift
        $start = Carbon::createFromFormat('H:i', $startTime, 'Asia/Riyadh');
        $end = Carbon::createFromFormat('H:i', $endTime, 'Asia/Riyadh');
        
        Log::info('Parsed Times', [
            'start_obj' => $start->toIso8601String(),
            'end_obj' => $end->toIso8601String(),
            'start_fmt' => $start->format('H:i')
        ]);
        
        // Generate slots at 30-minute intervals
        while ($start->lt($end)) {
            $timeString = $start->format('H:i');
            // Only include 00 and 30 minutes
            if ($start->minute == 0 || $start->minute == 30) {
                $slots[] = $timeString;
            }
            $start->addMinutes(30);
        }
        
        Log::info('Generated Slots', ['slots' => $slots]);
        
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
        
        // Check if the selected payment method is enabled
        if ($method === 'cash' && !SiteSetting::isCashPaymentEnabled()) {
            $this->addError('paymentMethod', 'Cash payment method is currently disabled.');
            return;
        }
        
        if ($method === 'online' && !SiteSetting::isOnlinePaymentEnabled()) {
            $this->addError('paymentMethod', 'Online payment method is currently disabled.');
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
            // Get the authenticated customer
            $customer = auth('customer')->user();
            
            if (!$customer) {
                throw new \Exception('You must be logged in to create a booking.');
            }
            
            // Get the service
            $service = Service::find($this->selectedServiceId);
            
            // Parse date and time with Saudi Arabia timezone
            $bookingDate = Carbon::parse($this->selectedDate)->timezone('Asia/Riyadh');
            // Use createFromFormat to avoid timezone shifting issues
            $startTime = Carbon::createFromFormat('H:i', $this->selectedTime, 'Asia/Riyadh');

            // Generate reference code
            $referenceCode = Booking::generateReferenceCode();
            
            // Create the booking
            $this->booking = Booking::create([
                'customer_id' => $customer->id,
                'service_id' => $this->selectedServiceId,
                'booking_date' => $bookingDate->format('Y-m-d'),
                'start_time' => $startTime->format('H:i:s'),
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
        
        // Clear cache to ensure fresh payment method settings
        \Illuminate\Support\Facades\Cache::forget('site_settings');
        
        return view('livewire.create-booking', [
            'services' => Service::where('is_active', true)->get(),
            'dateAvailability' => $dateAvailability,
            'isCashPaymentEnabled' => SiteSetting::isCashPaymentEnabled(),
            'isOnlinePaymentEnabled' => SiteSetting::isOnlinePaymentEnabled(),
        ]);
    }
}