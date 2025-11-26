<?php

namespace App\Models;

use App\Notifications\BookingCancelled;
use App\Traits\BookingUtilities;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
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
        'number_of_people' => 'integer',
        'is_paid' => 'boolean',
        'rating' => 'integer',
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

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public static function createWithLock(array $data)
    {
        // Remove employee_id from lock key since we're removing it
        $lockKey = 'booking_' . $data['booking_date'] . '_' . $data['start_time'];
        
        return Cache::lock($lockKey, 10)->get(function () use ($data) {
            // Auto-generate reference code if not provided
            if (!isset($data['reference_code'])) {
                $data['reference_code'] = self::generateReferenceCode();
            }
            return static::create($data);
        });
    }
    
    public function cancel()
    {
        $this->update(['status' => 'cancelled']);
        
        // Send cancellation notification
        // In a real application, you would send this to the customer's email
        Log::info('Booking cancelled: ' . $this->reference_code);
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
    
    // Generate a unique 6-character alphanumeric reference code
    public static function generateReferenceCode(): string
    {
        do {
            $code = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 6));
        } while (self::where('reference_code', $code)->exists());
        
        return $code;
    }
}