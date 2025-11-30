<?php

namespace App\Notifications\Channels;

use App\Services\MsegatService;
use Illuminate\Notifications\Notification;

class MsegatSmsChannel
{
    protected MsegatService $msegatService;

    public function __construct(MsegatService $msegatService)
    {
        $this->msegatService = $msegatService;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        // Get the phone number from the notifiable entity
        $phoneNumber = $notifiable->phone ?? $notifiable->routeNotificationFor('msegat_sms');

        if (!$phoneNumber) {
            return;
        }

        // Get the SMS message from the notification
        $message = $notification->toMsegatSms($notifiable);

        if (!$message) {
            return;
        }

        // Send the SMS
        $this->msegatService->sendSms($phoneNumber, $message);
    }
}
