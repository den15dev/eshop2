<?php

namespace App\Notifications;

use App\Mail\OrderReadyMailable;
use App\Modules\Orders\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Notification;

class OrderReady extends Notification
{
    use Queueable;


    public function __construct(
        private readonly Order $order
    ){}


    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }


    public function toMail(object $notifiable): Mailable
    {
        $address = $this->order->email ?? $notifiable instanceof AnonymousNotifiable
            ? $notifiable->routeNotificationFor('mail')
            : $notifiable->email;

        return (new OrderReadyMailable($this->order))->to($address);
    }


    public function toArray(object $notifiable): array
    {
        return [
            'id' => $this->order->id,
            'total_cost_formatted' => $this->order->total_cost_formatted,
            'shop_address' => $this->order->shop->address,
        ];
    }
}
