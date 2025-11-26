<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CustomerController extends Controller
{
    public function profile()
    {
        /** @var \App\Models\Customer $customer */
        $customer = auth('customer')->user();
        
        return view('customer.profile', compact('customer'));
    }
    
    public function editProfile()
    {
        /** @var \App\Models\Customer $customer */
        $customer = auth('customer')->user();
        
        return view('customer.profile-edit', compact('customer'));
    }
    
    public function updateProfile(Request $request)
    {
        /** @var \App\Models\Customer $customer */
        $customer = auth('customer')->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);
        
        $customer->update($request->only(['name', 'phone', 'email']));
        
        return redirect()->route('customer.profile')->with('success', 'Profile updated successfully!');
    }
    
    public function bookings()
    {
        /** @var \App\Models\Customer $customer */
        $customer = auth('customer')->user();
        $bookings = $customer->bookings()->with(['service.images'])->latest()->paginate(10);
        
        return view('customer.bookings.index', compact('bookings'));
    }
    
    public function createBooking()
    {
        $services = Service::where('is_active', true)->get();
        
        return view('customer.bookings.create', compact('services'));
    }
    
    public function storeBooking(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'booking_date' => 'required|date|after:today',
            'start_time' => 'required|date_format:H:i',
            'number_of_people' => 'required|integer|min:1|max:10',
            'payment_method' => 'required|in:cash,online',
        ]);
        
        /** @var \App\Models\Customer $customer */
        $customer = auth('customer')->user();
        
        // Get the service to calculate duration
        $service = Service::findOrFail($request->service_id);
        
        // Use the service's default duration
        $duration = $service->duration_minutes;
        
        // Calculate end time
        $startTime = \Carbon\Carbon::createFromTimeString($request->start_time);
        $endTime = $startTime->copy()->addMinutes($duration);
        
        // Generate reference code
        $referenceCode = Booking::generateReferenceCode();
        
        // Create the booking
        $booking = Booking::create([
            'customer_id' => $customer->id,
            'service_id' => $request->service_id,
            'booking_date' => $request->booking_date,
            'start_time' => $request->start_time,
            'end_time' => $endTime->format('H:i:s'),
            'reference_code' => $referenceCode,
            'status' => ($request->payment_method === 'cash') ? 'confirmed' : 'pending',
            'number_of_people' => $request->number_of_people,
            'payment_method' => $request->payment_method,
            'is_paid' => ($request->payment_method === 'cash') ? false : null,
        ]);
        
        // Generate QR code with booking details
        $qrData = "Booking Reference: {$referenceCode}\n" .
                 "Service: " . $booking->service->name . "\n" .
                 "Date: " . $booking->booking_date->format('Y-m-d') . "\n" .
                 "Time: " . $booking->start_time->format('H:i') . " - " . $booking->end_time->format('H:i') . "\n" .
                 "People: " . $booking->number_of_people;
        
        // Save QR code to database
        $booking->update(['qr_code' => $qrData]);
        
        // If payment method is online, generate order reference
        if ($request->payment_method === 'online') {
            $orderRef = 'ORD-' . strtoupper(uniqid());
            $booking->update(['order_ref' => $orderRef]);
        }
        
        return redirect()->route('customer.bookings')->with('success', 'Booking created successfully!');
    }
    
    public function editBooking(Booking $booking)
    {
        // Check if the booking belongs to the authenticated customer
        /** @var \App\Models\Customer $customer */
        $customer = auth('customer')->user();
        if ($booking->customer_id !== $customer->id) {
            abort(403);
        }
        
        $services = Service::where('is_active', true)->get();
        
        return view('customer.bookings.edit', compact('booking', 'services'));
    }
    
    public function updateBooking(Request $request, Booking $booking)
    {
        // Check if the booking belongs to the authenticated customer
        /** @var \App\Models\Customer $customer */
        $customer = auth('customer')->user();
        if ($booking->customer_id !== $customer->id) {
            abort(403);
        }
        
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'booking_date' => 'required|date|after:yesterday',
            'start_time' => 'required|date_format:H:i',
            'number_of_people' => 'required|integer|min:1|max:10',
            'payment_method' => 'required|in:cash,online',
        ]);
        
        // If booking is confirmed, change status back to pending
        $status = $booking->status;
        if ($status === 'confirmed') {
            $status = 'pending';
        }
        
        // Get the service to calculate duration
        $service = Service::findOrFail($request->service_id);
        
        // Use the service's default duration
        $duration = $service->duration_minutes;
        
        // Calculate end time
        $startTime = \Carbon\Carbon::createFromTimeString($request->start_time);
        $endTime = $startTime->copy()->addMinutes($duration);
        
        // Update the booking
        $booking->update([
            'service_id' => $request->service_id,
            'booking_date' => $request->booking_date,
            'start_time' => $request->start_time,
            'end_time' => $endTime->format('H:i:s'),
            'status' => $status,
            'number_of_people' => $request->number_of_people,
            'payment_method' => $request->payment_method,
        ]);
        
        return redirect()->route('customer.bookings')->with('success', 'Booking updated successfully!');
    }
    
    public function cancelBooking(Booking $booking)
    {
        // Check if the booking belongs to the authenticated customer
        /** @var \App\Models\Customer $customer */
        $customer = auth('customer')->user();
        if ($booking->customer_id !== $customer->id) {
            abort(403);
        }
        
        $booking->update(['status' => 'cancelled']);
        
        return redirect()->route('customer.bookings')->with('success', 'Booking cancelled successfully!');
    }
}