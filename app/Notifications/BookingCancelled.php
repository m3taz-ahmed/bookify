<?php

namespace App\Notifications;

use App\Models\Booking;
use App\Notifications\Channels\MsegatSmsChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingCancelled extends Notification implements ShouldQueue
{
    use Queueable;

    public $tries = 5;

    public function backoff(): array
    {
        return [10, 60, 300];
    }



    protected $booking;

    /**
     * Create a new notification instance.
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
        $this->onQueue('notifications');
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
        
        // Mail channel disabled in this project
        
        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Booking Cancelled - ' . $this->booking->reference_code)
            ->greeting('Hello ' . $this->booking->customer_name . '!')
            ->line('Your booking has been cancelled.')
            ->line('Service: ' . $this->booking->service->name_en)
            ->line('Original Date: ' . $this->booking->booking_date->format('M d, Y'))
            ->line('Original Time: ' . $this->booking->start_time . ' - ' . $this->booking->end_time)
            ->line('If you have any questions, please contact us.')
            ->action('Book Another Service', url('/book'))
            ->line('We hope to serve you again soon!');
    }

    /**
     * Get the SMS representation of the notification.
     */
    public function toMsegatSms(object $notifiable): string
    {
        // Get SMS templates from database
        $cancelledMessageEn = \App\Models\SiteSetting::get('sms_template_cancelled_en', "Hello {customer_name}, your booking has been cancelled.\nService: {service_name}\nDate: {booking_date}\nTime: {start_time}\nReference Code: {reference_code}");
        $cancelledMessageAr = \App\Models\SiteSetting::get('sms_template_cancelled_ar', "مرحباً {customer_name}، تم إلغاء حجزك\nالخدمة: {service_name}\nالتاريخ: {booking_date}\nالوقت: {start_time}\nرمز الحجز: {reference_code}");
        
        $serviceName = $this->booking->service->name_ar ?? $this->booking->service->name_en;
        $date = $this->booking->booking_date->format('Y-m-d');
        $time = $this->booking->start_time;
        $refCode = $this->booking->reference_code;
        $customerName = $this->booking->customer_name;
        
        // Replace placeholders in Arabic template (default)
        $message = str_replace(
            ['{customer_name}', '{service_name}', '{booking_date}', '{start_time}', '{reference_code}'],
            [$customerName, $serviceName, $date, $time, $refCode],
            $cancelledMessageAr
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
            'message' => 'Your booking has been cancelled.',
        ];
    }
}