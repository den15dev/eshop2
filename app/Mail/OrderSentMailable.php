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

class OrderSentMailable extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        private readonly Order $order
    ){}


    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('app.mail_from_address'), __('general.app_name', [], $this->order->language_id)),
            subject: __('notifications.order_sent.subject', ['id' => $this->order->id], $this->order->language_id),
        );
    }


    public function content(): Content
    {
        $order = $this->order;

        return new Content(
            view: 'emails.order-sent',
            with: compact('order'),
        );
    }


    public function attachments(): array
    {
        return [];
    }
}
