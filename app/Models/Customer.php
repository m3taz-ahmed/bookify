<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Customer extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'phone',
        'otp_code',
        'otp_expires_at',
    ];

    protected $hidden = [
        'remember_token',
        'otp_code',
        'otp_expires_at',
    ];

    protected $casts = [
        'otp_expires_at' => 'datetime',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'customer_id');
    }

    /**
     * Generate a 6-digit OTP code
     */
    public function generateOtp(): string
    {
        // Generate a random 6-digit OTP
        $otp = str_pad((string) random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
        $this->otp_code = Hash::make($otp);
        $this->otp_expires_at = now()->addMinutes(5); // 5 minutes expiration
        $this->save();
        
        return $otp;
    }

    /**
     * Verify the provided OTP
     */
    public function verifyOtp(string $otp): bool
    {
        // Check if OTP exists and hasn't expired
        if (!$this->otp_code || !$this->otp_expires_at || now()->isAfter($this->otp_expires_at)) {
            return false;
        }
        
        // Verify the OTP
        return Hash::check($otp, $this->otp_code);
    }

    /**
     * Clear the OTP after successful verification
     */
    public function clearOtp(): void
    {
        $this->otp_code = null;
        $this->otp_expires_at = null;
        $this->save();
    }
}