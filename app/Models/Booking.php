<?php

namespace App\Models;

use App\Notifications\BookingCancelled;
use App\Traits\BookingUtilities;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Booking extends Model
{
    use HasFactory, BookingUtilities, LogsActivity;

    protected $guarded = [];

    protected $casts = [
        'booking_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'checked_in_at' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Booking {$eventName}");
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public static function createWithLock(array $data)
    {
        $lockKey = 'booking_' . $data['booking_date'] . '_' . $data['start_time'] . '_' . $data['employee_id'];
        
        return Cache::lock($lockKey, 10)->get(function () use ($data) {
            return static::create($data);
        });
    }
    
    public function cancel()
    {
        $this->update(['status' => 'cancelled']);
        
        // Send cancellation notification
        // In a real application, you would send this to the customer's email
        \Log::info('Booking cancelled: ' . $this->reference_code);
    }
    
    public function getDurationAttribute()
    {
        return $this->end_time->diffInMinutes($this->start_time);
    }
    
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'confirmed' => 'bg-blue-100 text-blue-800',
            'completed' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}