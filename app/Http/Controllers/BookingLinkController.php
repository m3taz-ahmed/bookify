<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\SiteSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingLinkController extends Controller
{
    public function show(Request $request, int $customer, string $reference)
    {
        $booking = Booking::with(['customer', 'items.service.images'])
            ->where('customer_id', $customer)
            ->where('reference_code', $reference)
            ->first();

        if (!$booking) {
            return response()->view('booking.link', [
                'error' => true,
                'errorMessage' => app()->getLocale() === 'ar' ? 'لا يوجد حجز بهذه البيانات' : 'No booking found for this link',
            ], 404);
        }

        $visitDuration = SiteSetting::get('visit_duration', 120);
        $duration = (int) (is_array($visitDuration) ? ($visitDuration['value'] ?? 120) : $visitDuration);

        $date = $booking->booking_date instanceof Carbon ? $booking->booking_date : Carbon::parse($booking->booking_date);
        $start = $booking->start_time instanceof Carbon ? $booking->start_time : Carbon::createFromTimeString($booking->start_time);
        $start = $start->copy()->setDate($date->year, $date->month, $date->day)->timezone('Asia/Riyadh');
        $end = $start->copy()->addMinutes($duration);

        $now = Carbon::now('Asia/Riyadh');
        $isExpired = $now->gt($end);

        return view('booking.link', [
            'booking' => $booking,
            'endTime' => $end,
            'isExpired' => $isExpired,
            'error' => false,
        ]);
    }
}
