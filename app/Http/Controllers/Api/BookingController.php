<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::with(['service'])->get();
        
        return response()->json([
            'success' => true,
            'data' => $bookings
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'service_id' => 'required|exists:services,id',
            'booking_date' => 'required|date|after:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $booking = Booking::createWithLock($validator->validated());
            
            return response()->json([
                'success' => true,
                'message' => 'Booking created successfully',
                'data' => $booking
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create booking',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        $booking->load(['service']);
        
        return response()->json([
            'success' => true,
            'data' => $booking
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'sometimes|in:pending,confirmed,completed,cancelled',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $booking->update($validator->validated());
            
            return response()->json([
                'success' => true,
                'message' => 'Booking updated successfully',
                'data' => $booking
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update booking',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        try {
            $booking->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Booking deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete booking',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get available time slots for a service and date
     */
    public function getAvailableSlots(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_id' => 'required|exists:services,id',
            'date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $serviceId = $request->service_id;
        $date = $request->date;
        
        $visitDuration = \App\Models\SiteSetting::get('visit_duration', 120);
        $duration = (int) (is_array($visitDuration) ? ($visitDuration['value'] ?? 120) : $visitDuration);
        
        // Define default working hours (9 AM to 5 PM)
        // In a real application, this might be configurable
        $startHour = 9; // 9 AM
        $endHour = 17;  // 5 PM
        
        $start = strtotime($startHour . ':00');
        $end = strtotime($endHour . ':00');
        
        // Get existing bookings for this date
        $existingBookings = Booking::where('booking_date', $date)->get();
            
        $slots = [];
        
        // Generate slots
        for ($time = $start; $time < $end; $time += ($duration * 60)) {
            $slotTime = date('H:i', $time);
            $slotEndTime = date('H:i', $time + ($duration * 60));
            
            // Check if slot is available
            $isAvailable = true;
            foreach ($existingBookings as $booking) {
                $bookingStart = \Carbon\Carbon::createFromFormat('H:i:s', $booking->start_time, 'Asia/Riyadh');
                $bookingEnd = $bookingStart->copy()->addMinutes($duration);
                $slotStart = \Carbon\Carbon::createFromFormat('H:i', $slotTime, 'Asia/Riyadh');
                $slotEnd = \Carbon\Carbon::createFromFormat('H:i', $slotEndTime, 'Asia/Riyadh');

                if ($slotStart < $bookingEnd && $slotEnd > $bookingStart) {
                    $isAvailable = false;
                    break;
                }
            }
            
            if ($isAvailable) {
                $slots[] = [
                    'start_time' => $slotTime,
                    'end_time' => $slotEndTime,
                ];
            }
        }
        
        return response()->json([
            'success' => true,
            'data' => $slots
        ]);
    }
}
