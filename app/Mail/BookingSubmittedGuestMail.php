<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingSubmittedGuestMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Booking $booking)
    {
    }

    public function build(): self
    {
        return $this->subject('We received your booking request — '.config('app.name'))
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->view('emails.booking-submitted-guest');
    }
}
