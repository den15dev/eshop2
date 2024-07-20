<?php

namespace App\Mail;

use App\Modules\Orders\Models\Order;
use Illuminate\Bus\Queueable;
//use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderReadyMailable extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        private readonly Order $order
    ){}


    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('app.mail_from_address'), __('general.app_name', [], $this->order->language_id)),
            subject: __('notifications.order_ready.subject', ['id' => $this->order->id], $this->order->language_id),
        );
    }


    public function content(): Content
    {
        $order = $this->order->load('shop:id,name,address');

        return new Content(
            view: 'emails.order-ready',
            with: compact('order'),
        );
    }


    public function attachments(): array
    {
        return [];
    }
}
