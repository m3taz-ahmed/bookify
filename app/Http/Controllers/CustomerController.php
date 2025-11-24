<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CustomerController extends Controller
{
    public function dashboard()
    {
        $customer = Auth::guard('customer')->user();
        // Using direct relationship with eager loading
        $bookings = $customer->bookings()->with(['service', 'employee'])->latest()->get();
        
        return view('customer.dashboard', compact('bookings'));
    }
    
    public function bookings()
    {
        /** @var Customer $customer */
        $customer = Auth::guard('customer')->user();
        $bookings = $customer->bookings()->with(['service', 'employee'])->latest()->paginate(10);
        
        return view('customer.bookings.index', compact('bookings'));
    }
    
    public function createBooking()
    {
        return view('customer.bookings.create');
    }
    
    public function storeBooking(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'employee_id' => 'required|exists:users,id',
            'booking_date' => 'required|date|after:today',
            'start_time' => 'required|date_format:H:i',
        ]);
        
        $customer = Auth::guard('customer')->user();
        
        // Get the service and employee to calculate duration
        $service = Service::findOrFail($request->service_id);
        $employee = User::findOrFail($request->employee_id);
        
        // Check if employee has a specific duration for this service
        $employeeDuration = $employee->serviceDurations()
            ->where('service_id', $service->id)
            ->first();
        
        $duration = $employeeDuration ? $employeeDuration->duration : $service->duration_minutes;
        
        // Calculate end time
        $startTime = \Carbon\Carbon::createFromTimeString($request->start_time);
        $endTime = $startTime->copy()->addMinutes($duration);
        
        // Create the booking
        $booking = Booking::create([
            'customer_id' => $customer->id,
            'service_id' => $request->service_id,
            'employee_id' => $request->employee_id,
            'booking_date' => $request->booking_date,
            'start_time' => $request->start_time,
            'end_time' => $endTime->format('H:i:s'),
            'reference_code' => strtoupper(uniqid('BKNG')),
            'status' => 'pending',
        ]);
        
        return redirect()->route('customer.bookings')->with('success', 'Booking created successfully!');
    }
    
    public function editBooking(Booking $booking)
    {
        // Check if the booking belongs to the authenticated customer
        if ($booking->customer_id !== Auth::guard('customer')->id()) {
            abort(403);
        }
        
        // If booking is confirmed, change status back to pending
        if ($booking->status === 'confirmed') {
            $booking->update(['status' => 'pending']);
        }
        
        $services = Service::where('is_active', true)->get();
        $employees = User::whereHas('roles', function ($query) {
            $query->where('name', 'employee');
        })->get();
        
        return view('customer.bookings.edit', compact('booking', 'services', 'employees'));
    }
    
    public function updateBooking(Request $request, Booking $booking)
    {
        // Check if the booking belongs to the authenticated customer
        if ($booking->customer_id !== Auth::guard('customer')->id()) {
            abort(403);
        }
        
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'employee_id' => 'required|exists:users,id',
            'booking_date' => 'required|date|after:today',
            'start_time' => 'required|date_format:H:i',
        ]);
        
        // If booking is confirmed, change status back to pending
        $status = $booking->status;
        if ($status === 'confirmed') {
            $status = 'pending';
        }
        
        // Get the service and employee to calculate duration
        $service = Service::findOrFail($request->service_id);
        $employee = User::findOrFail($request->employee_id);
        
        // Check if employee has a specific duration for this service
        $employeeDuration = $employee->serviceDurations()
            ->where('service_id', $service->id)
            ->first();
        
        $duration = $employeeDuration ? $employeeDuration->duration : $service->duration_minutes;
        
        // Calculate end time
        $startTime = \Carbon\Carbon::createFromTimeString($request->start_time);
        $endTime = $startTime->copy()->addMinutes($duration);
        
        // Update the booking
        $booking->update([
            'service_id' => $request->service_id,
            'employee_id' => $request->employee_id,
            'booking_date' => $request->booking_date,
            'start_time' => $request->start_time,
            'end_time' => $endTime->format('H:i:s'),
            'status' => $status,
        ]);
        
        return redirect()->route('customer.bookings')->with('success', 'Booking updated successfully!');
    }
    
    public function cancelBooking(Booking $booking)
    {
        // Check if the booking belongs to the authenticated customer
        if ($booking->customer_id !== Auth::guard('customer')->id()) {
            abort(403);
        }
        
        // Only allow cancellation if booking is not completed or already cancelled
        if (!in_array($booking->status, ['completed', 'cancelled'])) {
            $booking->update(['status' => 'cancelled']);
            return redirect()->route('customer.bookings')->with('success', 'Booking cancelled successfully!');
        }
        
        return redirect()->route('customer.bookings')->with('error', 'Cannot cancel this booking.');
    }
}
