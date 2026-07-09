<?php

namespace App\Mail;

use App\Models\BlogComment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BlogCommentGuestMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public BlogComment $comment)
    {
    }

    public function build(): self
    {
        return $this->subject('We received your blog comment')
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->view('emails.blog-comment-guest');
    }
}
