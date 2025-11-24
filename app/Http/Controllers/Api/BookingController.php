<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::with(['service', 'employee'])->get();
        
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
            'employee_id' => 'required|exists:users,id',
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
        $booking->load(['service', 'employee']);
        
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
            'checked_in_at' => 'sometimes|date',
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
        $dayOfWeek = date('w', strtotime($date));
        
        // Get all employees who work on this day
        $shifts = Shift::where('day_of_week', $dayOfWeek)
            ->with('user')
            ->get();
            
        $slots = [];
        
        foreach ($shifts as $shift) {
            $service = Service::find($serviceId);
            $duration = $service->duration_minutes;
            
            $start = strtotime($shift->start_time);
            $end = strtotime($shift->end_time);
            
            // Get existing bookings for this employee on this date
            $existingBookings = Booking::where('employee_id', $shift->user_id)
                ->where('booking_date', $date)
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
                    $slots[] = [
                        'employee_id' => $shift->user_id,
                        'employee_name' => $shift->user->name,
                        'start_time' => $slotTime,
                        'end_time' => $slotEndTime,
                    ];
                }
            }
        }
        
        return response()->json([
            'success' => true,
            'data' => $slots
        ]);
    }
}