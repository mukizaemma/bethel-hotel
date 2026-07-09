<?php

namespace App\Mail;

use App\Models\Review;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReviewSubmittedAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Review $review)
    {
    }

    public function build(): self
    {
        return $this->subject('New review submitted — '.$this->review->names)
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->view('emails.review-submitted-admin');
    }
}
