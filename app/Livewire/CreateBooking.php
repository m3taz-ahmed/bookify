<?php

namespace App\Livewire;

use App\Models\Service;
use App\Models\Booking;
use App\Services\BookingService;
use App\Http\Requests\StoreBookingRequest;
use Livewire\Component;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Auth;

class CreateBooking extends Component
{
    public $step = 1;
    public $services;
    public $selectedService;
    public $numberOfPeople = 1;
    public $selectedDate;
    public $availableSlots;
    public $selectedSlot;
    public $customerName;
    public $customerPhone;
    public $referenceCode;
    public $qrCode;
    public $paymentMethod;
    public $orderRef;
    
    protected $bookingService;

    public function boot(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function mount()
    {
        $this->services = Service::where('is_active', true)->get();
        // Set default customer info if authenticated
        if (Auth::guard('customer')->check()) {
            $customer = Auth::guard('customer')->user();
            $this->customerName = $customer->name;
            $this->customerPhone = $customer->phone;
        }
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

    public function selectDate($date)
    {
        $this->selectedDate = $date;
        $this->loadAvailableSlots();
        $this->step = 4;
    }
    
    public function updatedSelectedDate($value)
    {
        if ($value) {
            $this->loadAvailableSlots();
            // Only advance to step 4 if there are available slots
            if (!empty($this->availableSlots)) {
                $this->step = 4;
            }
        }
    }

    public function loadAvailableSlots()
    {
        $this->availableSlots = $this->bookingService->generateTimeSlots($this->selectedService, $this->selectedDate);
    }

    public function selectSlot($startTime)
    {
        $this->selectedSlot = [
            'start_time' => $startTime
        ];
        $this->step = 5;
    }

    public function selectPaymentMethod($method)
    {
        $this->paymentMethod = $method;
        $this->step = 6;
    }

    public function saveBooking()
    {
        // Create a temporary request to validate the data
        $request = new StoreBookingRequest();
        $request->merge([
            'customer_name' => $this->customerName,
            'customer_phone' => $this->customerPhone,
            'service_id' => $this->selectedService,
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
        
        $this->referenceCode = Booking::generateReferenceCode();
        
        try {
            // Prepare booking data
            $bookingData = [
                'reference_code' => $this->referenceCode,
                'customer_name' => $this->customerName,
                'customer_phone' => $this->customerPhone,
                'service_id' => $this->selectedService,
                'booking_date' => $this->selectedDate,
                'start_time' => $this->selectedSlot['start_time'],
                'end_time' => $slot['end_time'],
                'status' => 'pending',
                'number_of_people' => $this->numberOfPeople,
                'payment_method' => $this->paymentMethod,
                'is_paid' => ($this->paymentMethod === 'cash') ? false : null, // For online payments, we'll set this after payment confirmation
            ];
            
            // Add customer_id if authenticated
            if (Auth::guard('customer')->check()) {
                $bookingData['customer_id'] = Auth::guard('customer')->id();
                // Remove customer_name and customer_phone as they're in the customer table
                unset($bookingData['customer_name'], $bookingData['customer_phone']);
            }
            
            $booking = $this->bookingService->createBookingWithLock($bookingData);
            
            // Generate QR code with booking details
            $qrData = "Booking Reference: {$this->referenceCode}\n" .
                     "Service: " . $booking->service->name . "\n" .
                     "Date: " . $booking->booking_date->format('Y-m-d') . "\n" .
                     "Time: " . $booking->start_time->format('H:i') . " - " . $booking->end_time->format('H:i') . "\n" .
                     "People: " . $booking->number_of_people;
            
            // Save QR code to database
            $booking->update(['qr_code' => $qrData]);
            
            // Generate QR code image
            $this->qrCode = base64_encode(QrCode::format('png')->size(200)->generate($qrData));
            
            // If payment method is cash, mark as confirmed
            if ($this->paymentMethod === 'cash') {
                $booking->update(['status' => 'confirmed']);
            } else {
                // For online payment, generate order reference
                $this->orderRef = 'ORD-' . strtoupper(uniqid());
                $booking->update(['order_ref' => $this->orderRef]);
            }
            
            $this->step = 7; // Show success and QR code
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