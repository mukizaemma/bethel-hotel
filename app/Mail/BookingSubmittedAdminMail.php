<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingSubmittedAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Booking $booking)
    {
    }

    public function build(): self
    {
        $type = $this->booking->reservation_type ?? 'room';

        return $this->subject('New booking request — '.$this->booking->names)
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->view('emails.booking-submitted-admin');
    }
}
