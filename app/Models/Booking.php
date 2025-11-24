<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Booking extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'booking_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'checked_in_at' => 'datetime',
    ];

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
}