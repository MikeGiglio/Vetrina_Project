<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReviewOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $code, public string $name)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->code . ' è il tuo codice di verifica - Mau House 44',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.review-otp',
            with: [
                'code' => $this->code,
                'name' => $this->name,
            ],
        );
    }
}
