<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Doctor;

class DocUserCreated extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Doctor $doctor, public string $password)
    {

    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Регистрация на портале сотрудников Клиники Долголетия',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.doc-created',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
