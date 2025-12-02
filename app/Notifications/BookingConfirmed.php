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
        // Get SMS templates from database
        $bookingMessageEn = \App\Models\SiteSetting::get('sms_template_booking_en', "Hello {customer_name}, your booking has been confirmed.\nService: {service_name}\nDate: {booking_date}\nTime: {start_time}\nReference Code: {reference_code}");
        $bookingMessageAr = \App\Models\SiteSetting::get('sms_template_booking_ar', "مرحباً {customer_name}، تم تأكيد حجزك\nالخدمة: {service_name}\nالتاريخ: {booking_date}\nالوقت: {start_time}\nرمز الحجز: {reference_code}");
        
        $serviceName = $this->booking->service->name_ar ?? $this->booking->service->name_en;
        $date = $this->booking->booking_date->format('Y-m-d');
        // Format time to show only H:i (e.g. 14:30)
        $time = $this->booking->start_time->format('H:i');
        $refCode = $this->booking->reference_code;
        $customerName = $this->booking->customer_name;
        
        // Replace placeholders in Arabic template (default)
        $message = str_replace(
            ['{customer_name}', '{service_name}', '{booking_date}', '{start_time}', '{reference_code}'],
            [$customerName, $serviceName, $date, $time, $refCode],
            $bookingMessageAr
        );
        
        return $message;
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