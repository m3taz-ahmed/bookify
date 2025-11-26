<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CheckInController extends Controller
{
    public function checkIn($reference)
    {
        try {
            $booking = Booking::where('reference_code', $reference)->first();
            
            if (!$booking) {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking not found'
                ], 404);
            }
            
            // Check if user is authorized to check in this booking
            if (!Gate::allows('checkIn', $booking)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized to check in this booking'
                ], 403);
            }
            
            if ($booking->status !== 'confirmed') {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking is not confirmed'
                ], 400);
            }
            
            // Update booking status
            $booking->update([
                'status' => 'completed'
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Check-in successful',
                'booking' => $booking
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during check-in'
            ], 500);
        }
    }
    
    public function showCheckInPage($reference)
    {
        $booking = Booking::where('reference_code', $reference)->first();
        
        if (!$booking) {
            abort(404);
        }
        
        // Check if user is authorized to check in this booking
        if (!Gate::allows('checkIn', $booking)) {
            abort(403);
        }
        
        return view('check-in', compact('booking'));
    }
}