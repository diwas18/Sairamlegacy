<?php

// app/Notifications/GlobalNotification.php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class GlobalNotification extends Notification
{
    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('Hello ' . $notifiable->name)
            ->line($this->message)
            ->action('View Site', url('/'))
            ->line('Thanks for staying connected!')
            ->salutation('Regards, Sairam Chasma Pasal');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => $this->message,
        ];
    }
}

