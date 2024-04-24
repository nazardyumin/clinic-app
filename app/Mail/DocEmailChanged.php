<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Doctor;

class DocEmailChanged extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Doctor $doctor, public string $password)
    {

    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Уведомление о смене электронной почты и пароля',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.doc-email-changed',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
