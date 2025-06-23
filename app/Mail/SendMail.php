<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $User;
    public string $record;
    /**
     * Create a new conten$User instance.
     */
    public function __construct(string $User, string $record)
    {
        $this->User = $User;
        $this->record = $record;
    }

    /**
     * Get the conten$User envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: 'notificaciones@hunabku.com',
            subject: 'Buenos dias '.$this->User. ', su cuenta ha sido modificada',
        );
    }

    /**
     * Get the conten$User content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.prueba',
            with: [
                'message' => $this->User,
                
            ]
        );
    }

    /**
     * Get the attachments for the conten$User.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
