<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $fillable = [
        'setting_key',
        'setting_value',
        'description'
    ];

    protected $casts = [
        'setting_value' => 'array'
    ];


    /**
     * Get a setting value by key
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        // Try to get from cache first
        $value = Cache::remember("site_setting_{$key}", 3600, function () use ($key) {
            $setting = self::where('setting_key', $key)->first();
            return $setting ? $setting->setting_value : null;
        });

        return $value ?? $default;
    }

    /**
     * Set a setting value
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function set($key, $value)
    {
        $setting = self::where('setting_key', $key)->first();
        
        if ($setting) {
            $setting->update(['setting_value' => $value]);
        } else {
            self::create([
                'setting_key' => $key,
                'setting_value' => $value
            ]);
        }

        // Clear cache
        Cache::forget("site_setting_{$key}");
    }

    /**
     * Get the maximum capacity setting
     *
     * @return int
     */
    public static function getMaxCapacity()
    {
        return (int) self::get('max_capacity', 200);
    }

    /**
     * Get working hours for a specific day
     *
     * @param string $dayOfWeek (e.g., 'monday', 'tuesday', etc.)
     * @return array|null
     */
    public static function getWorkingHours($dayOfWeek)
    {
        $workingHours = self::get('working_hours', []);
        
        // If workingHours is a JSON string, decode it
        if (is_string($workingHours)) {
            $workingHours = json_decode($workingHours, true);
            // If JSON decoding fails, return empty array
            if (json_last_error() !== JSON_ERROR_NONE) {
                $workingHours = [];
            }
        }
        
        // If workingHours is not an array at this point, make it an array
        if (!is_array($workingHours)) {
            $workingHours = [];
        }
        
        if (isset($workingHours[$dayOfWeek])) {
            return $workingHours[$dayOfWeek];
        }
        
        return null; // Closed
    }

    /**
     * Check if a date is a working day
     *
     * @param \Carbon\Carbon $date
     * @return bool
     */
    public static function isWorkingDay($date)
    {
        $dayOfWeek = strtolower($date->format('l')); // 'monday', 'tuesday', etc.
        $workingHours = self::getWorkingHours($dayOfWeek);
        
        // Handle both old format (single time slot) and new format (multiple time slots)
        if (is_array($workingHours)) {
            // Check if it's the old format (single time slot)
            if (isset($workingHours['start']) || isset($workingHours['end'])) {
                return true;
            }
            // Check if it's the new format (multiple time slots)
            return count($workingHours) > 0;
        }
        
        return $workingHours !== null;
    }

    /**
     * Get the start time for a working day (first time slot)
     *
     * @param \Carbon\Carbon $date
     * @return string|null
     */
    public static function getStartTime($date)
    {
        $dayOfWeek = strtolower($date->format('l'));
        $workingHours = self::getWorkingHours($dayOfWeek);
        
        // Handle both old format (single time slot) and new format (multiple time slots)
        if ($workingHours) {
            if (isset($workingHours['start'])) {
                // Old format - single time slot
                return $workingHours['start'];
            } elseif (is_array($workingHours) && isset($workingHours[0]['start'])) {
                // New format - multiple time slots, return first slot
                return $workingHours[0]['start'];
            }
        }
        
        return null;
    }

    /**
     * Get the end time for a working day (last time slot)
     *
     * @param \Carbon\Carbon $date
     * @return string|null
     */
    public static function getEndTime($date)
    {
        $dayOfWeek = strtolower($date->format('l'));
        $workingHours = self::getWorkingHours($dayOfWeek);
        
        // Handle both old format (single time slot) and new format (multiple time slots)
        if ($workingHours) {
            if (isset($workingHours['end'])) {
                // Old format - single time slot
                return $workingHours['end'];
            } elseif (is_array($workingHours) && count($workingHours) > 0) {
                // New format - multiple time slots, return last slot
                $lastSlot = end($workingHours);
                return $lastSlot['end'] ?? null;
            }
        }
        
        return null;
    }
    
    /**
     * Get all time slots for a specific day
     *
     * @param \Carbon\Carbon $date
     * @return array
     */
    public static function getTimeSlots($date)
    {
        $dayOfWeek = strtolower($date->format('l'));
        $workingHours = self::getWorkingHours($dayOfWeek);
        
        // Handle both old format (single time slot) and new format (multiple time slots)
        if ($workingHours) {
            if (isset($workingHours['start']) && isset($workingHours['end'])) {
                // Old format - single time slot
                return [$workingHours];
            } elseif (is_array($workingHours)) {
                // New format - multiple time slots
                return $workingHours;
            }
        }
        
        return [];
    }
}
