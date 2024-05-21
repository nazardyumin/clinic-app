<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppointmentNotification extends Mailable
{
    use Queueable, SerializesModels;

    protected Appointment $app;

    public function __construct(Appointment $app)
    {
        $this->app = $app;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Напоминание о записи на приём к врачу',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.appointment-notification',
            with: [
                'app' => $this->app,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
