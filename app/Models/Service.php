<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
            'name_en',
            'name_ar',
            'description',
            'duration_minutes',
            'price',
            'is_active',
            'sort_order',
        ];

    protected $casts = [
        'duration_minutes' => 'integer',
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
    
    protected static function booted()
    {
        static::creating(function ($service) {
            if (is_null($service->sort_order)) {
                $service->sort_order = 0;
            }
        });
    }
    
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    
    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->price, 2);
    }
    
    public function getDurationHoursAttribute()
    {
        $hours = floor($this->duration_minutes / 60);
        $minutes = $this->duration_minutes % 60;
        
        if ($hours > 0 && $minutes > 0) {
            return $hours . 'h ' . $minutes . 'm';
        } elseif ($hours > 0) {
            return $hours . 'h';
        } else {
            return $minutes . 'm';
        }
    }
    
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }
}