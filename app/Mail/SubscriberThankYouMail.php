<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscriberThankYouMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $emailAddress)
    {
    }

    public function build(): self
    {
        return $this->subject('Thank you for subscribing — '.config('app.name'))
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->view('emails.subscriber-thank-you');
    }
}
