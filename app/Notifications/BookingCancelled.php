<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingCancelled extends Notification
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
        return ['mail'];
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