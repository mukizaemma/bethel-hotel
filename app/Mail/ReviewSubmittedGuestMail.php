<?php

namespace App\Mail;

use App\Models\Review;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReviewSubmittedGuestMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Review $review)
    {
    }

    public function build(): self
    {
        return $this->subject('We received your review — '.config('app.name'))
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->view('emails.review-submitted-guest');
    }
}
