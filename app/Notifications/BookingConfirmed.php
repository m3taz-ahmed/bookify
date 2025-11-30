<?php

namespace App\Notifications;

use App\Models\Booking;
use App\Notifications\Channels\MsegatSmsChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingConfirmed extends Notification
{
    use Queueable;

    protected $booking;

    /**
     * Create a new notification instance.
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        $channels = ['database'];
        
        // Add SMS channel if customer has phone number
        if ($notifiable->phone) {
            $channels[] = MsegatSmsChannel::class;
        }
        
        // Add mail channel if customer has email
        if ($notifiable->email) {
            $channels[] = 'mail';
        }
        
        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Booking Confirmation - ' . $this->booking->reference_code)
            ->greeting('Hello ' . $this->booking->customer_name . '!')
            ->line('Your booking has been confirmed.')
            ->line('Service: ' . $this->booking->service->name_en)
            ->line('Date: ' . $this->booking->booking_date->format('M d, Y'))
            ->line('Time: ' . $this->booking->start_time . ' - ' . $this->booking->end_time)
            // Employee information removed as per requirements
            ->action('View Booking', url('/check-in-page/' . $this->booking->reference_code))
            ->line('Thank you for choosing our services!');
    }

    /**
     * Get the SMS representation of the notification.
     */
    public function toMsegatSms(object $notifiable): string
    {
        $serviceName = $this->booking->service->name_ar ?? $this->booking->service->name_en;
        $date = $this->booking->booking_date->format('Y-m-d');
        // Format time to show only H:i (e.g. 14:30)
        $time = $this->booking->start_time->format('H:i');
        $refCode = $this->booking->reference_code;
        
        return "مرحباً ، تم تأكيد حجزك\n"
            . "الخدمة: {$serviceName}\n"
            . "التاريخ: {$date}\n"
            . "الوقت: {$time}\n"
            . "رمز الحجز: {$refCode}";
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'reference_code' => $this->booking->reference_code,
            'message' => 'Your booking has been confirmed.',
        ];
    }
}