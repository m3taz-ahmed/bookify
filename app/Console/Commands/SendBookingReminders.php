<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendBookingReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:send-reminders {--hours=24 : Hours before booking to send reminder}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders for upcoming bookings';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $hours = $this->option('hours');
        $reminderTime = now()->addHours($hours);
        
        // Get bookings that are scheduled for the reminder time
        $bookings = Booking::where('booking_date', $reminderTime->toDateString())
            ->where('start_time', $reminderTime->format('H:i:s'))
            ->where('status', 'confirmed')
            ->get();
            
        foreach ($bookings as $booking) {
            // In a real application, you would send an email or SMS reminder
            // For now, we'll just log it
            Log::info("Booking reminder sent for booking: {$booking->reference_code}");
            
            // You could also send a notification:
            // $booking->customer->notify(new BookingReminder($booking));
        }
        
        $this->info("Sent {$bookings->count()} booking reminders.");
        
        return Command::SUCCESS;
    }
}