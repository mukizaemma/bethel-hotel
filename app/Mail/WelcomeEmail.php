<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public function __construct($user)
    {
        $this->user = $user;
        // $this->randomPassword = $randomPassword;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Account Created',
            from: new Address('iremetechnologies@gmail.com', 'Ireme Technologies'),
            to: [$this->user->email],
            bcc: ['mukizaemma34@gmail.com']
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.welcomeEmail',
            with: [
                'name' => $this->user->name,
                'email' => $this->user->email,
                // 'randomPassword' => $this->randomPassword,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
