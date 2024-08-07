<?php

namespace App\Mail;

use App\Modules\Users\Models\User;
use Illuminate\Bus\Queueable;
//use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerifyEmailMailable extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        private readonly object $notifiable,
        private readonly string $url,
    ){}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('app.mail_from_address'), __('general.app_name')),
            to: $this->notifiable->email,
            subject: __('notifications.verify_email.subject'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $user = $this->notifiable;
        $url = $this->url;

        return new Content(
            view: 'emails.verify-email',
            with: compact('user', 'url'),
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
