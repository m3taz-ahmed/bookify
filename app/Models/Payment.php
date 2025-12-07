<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Payment extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = [];

    protected $casts = [
        'amount_cents' => 'integer',
        'refund_amount_cents' => 'integer',
        'payment_data' => 'array',
        'callback_data' => 'array',
        'paid_at' => 'datetime',
        'failed_at' => 'datetime',
        'refunded_at' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Payment {$eventName}");
    }

    /**
     * Relationship: Payment belongs to a Booking
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Check if payment is successful
     */
    public function isSuccess(): bool
    {
        return $this->payment_status === 'success';
    }

    /**
     * Check if payment is pending
     */
    public function isPending(): bool
    {
        return $this->payment_status === 'pending';
    }

    /**
     * Check if payment has failed
     */
    public function isFailed(): bool
    {
        return $this->payment_status === 'failed';
    }

    /**
     * Check if payment is refunded (fully or partially)
     */
    public function isRefunded(): bool
    {
        return in_array($this->payment_status, ['refunded', 'partially_refunded']);
    }

    /**
     * Get amount in SAR (divide by 100)
     */
    public function getAmountAttribute(): float
    {
        return $this->amount_cents / 100;
    }

    /**
     * Get refund amount in SAR (divide by 100)
     */
    public function getRefundAmountAttribute(): float
    {
        return $this->refund_amount_cents / 100;
    }

    /**
     * Mark payment as successful
     */
    public function markAsSuccess(array $data = []): void
    {
        $this->update([
            'payment_status' => 'success',
            'paid_at' => now(),
            'callback_data' => $data,
        ]);
    }

    /**
     * Mark payment as failed
     */
    public function markAsFailed(string $reason = '', array $data = []): void
    {
        $this->update([
            'payment_status' => 'failed',
            'failed_at' => now(),
            'failed_reason' => $reason,
            'callback_data' => $data,
        ]);
    }

    /**
     * Mark payment as refunded
     */
    public function markAsRefunded(int $refundAmountCents = null, bool $partial = false): void
    {
        $refundAmount = $refundAmountCents ?? $this->amount_cents;
        
        $this->update([
            'payment_status' => $partial ? 'partially_refunded' : 'refunded',
            'refund_amount_cents' => $refundAmount,
            'refunded_at' => now(),
        ]);
    }

    /**
     * Scope: Get successful payments only
     */
    public function scopeSuccess($query)
    {
        return $query->where('payment_status', 'success');
    }

    /**
     * Scope: Get pending payments only
     */
    public function scopePending($query)
    {
        return $query->where('payment_status', 'pending');
    }

    /**
     * Scope: Get failed payments only
     */
    public function scopeFailed($query)
    {
        return $query->where('payment_status', 'failed');
    }

    /**
     * Generate a unique merchant order ID
     */
    public static function generateMerchantOrderId(): string
    {
        do {
            $orderId = 'BOOK-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -8));
        } while (self::where('merchant_order_id', $orderId)->exists());

        return $orderId;
    }
}
