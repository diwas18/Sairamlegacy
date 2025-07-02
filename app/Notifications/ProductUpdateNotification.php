<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProductUpdateNotification extends Notification
{
    use Queueable;

    protected $product;
    protected $message;

    public function __construct($product, $message)
    {
        $this->product = $product;
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['database', 'mail']; // Save in DB and send email
    }

    public function toMail($notifiable)
    {
        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('New Product Update')
            ->line($this->message)
            ->action('View Product', url(route('viewproduct', $this->product->id)))
            ->line('Thank you for shopping with us!')
             ->salutation('Regards, Sairam Chasma Pasal');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => $this->message,
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
        ];
    }
}

