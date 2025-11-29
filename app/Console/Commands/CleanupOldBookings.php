<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Illuminate\Console\Command;
use Carbon\Carbon;

class CleanupOldBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:cleanup {--days=30 : Number of days to keep bookings}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up old bookings that are older than specified days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = $this->option('days');
        $cutoffDate = Carbon::now()->timezone('Asia/Riyadh')->subDays($days);
        
        $deletedCount = Booking::where('created_at', '<', $cutoffDate)
            ->where('status', 'cancelled')
            ->delete();
            
        $this->info("Deleted {$deletedCount} old cancelled bookings.");
        
        return Command::SUCCESS;
    }
}