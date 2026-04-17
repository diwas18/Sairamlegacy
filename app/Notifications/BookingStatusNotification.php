<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class BookingStatusNotification extends Notification
{
    use Queueable;

    protected $booking;

    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable)
    {
        return ['mail']; // you can add 'database' later
    }

    public function toMail($notifiable)
{
    return (new MailMessage)
        ->subject('Sairam Chasma Pasal - Booking Update')
        ->greeting('Hello ' . $this->booking->name)

        ->line('Your appointment has been **' . strtoupper($this->booking->status) . '**.')

        ->line(' Date: ' . \Carbon\Carbon::parse($this->booking->booking_date)->format('d M Y'))
        ->line('Time: ' . \Carbon\Carbon::parse($this->booking->booking_time)->format('h:i A'))

        ->line('We look forward to serving you at **Sairam Chasma Pasal**.')

        ->salutation('Regards,
Sairam Chasma Pasal Team');
}
}
