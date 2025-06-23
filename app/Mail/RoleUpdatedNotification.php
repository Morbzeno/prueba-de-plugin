<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RoleUpdatedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public string $user;
    public string $role;
    public string $changes;
    /**
     * Create a new message instance.
     */
    public function __construct($role, $changes, $user)
    {
        $this->role = $role;
        $this->changes = $changes;
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: 'notificaciones@hunabku.com',
            subject: 'buenos dias '.$this->user,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return $this->subject("Se ha actualizado el rol: {$this->role->name}");
        // return new Content(
        //     view: 'view.name',
        // );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
