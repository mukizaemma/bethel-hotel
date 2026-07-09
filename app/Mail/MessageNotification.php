<?php

namespace App\Mail;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MessageNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $message;
    public function __construct(Message $message)
    {
        $this->message = $message;
    }
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
        ->replyTo('info@flystudy.rw')
        ->subject('New Message')
        ->view('emails.messageNotification')
        ->with([
            'message' => $this->message,
        ]);

    }
    public function attachments(): array
    {
        return [];
    }
}
