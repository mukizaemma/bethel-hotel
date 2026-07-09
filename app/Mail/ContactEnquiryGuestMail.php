<?php

namespace App\Mail;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactEnquiryGuestMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Message $enquiry)
    {
    }

    public function build(): self
    {
        $subject = 'We received your message — '.config('app.name');
        if (($this->enquiry->enquiry_type ?? '') === 'proposal') {
            $subject = 'We received your proposal request — '.config('app.name');
        }

        $type = $this->enquiry->enquiry_type ?? 'general';
        $enquiryTypeLine = match ($type) {
            'room' => 'room enquiry',
            'meetings' => 'workshop / meeting enquiry',
            'dining' => 'restaurant / dining enquiry',
            'proposal' => 'proposal request',
            default => 'message',
        };

        return $this->subject($subject)
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->view('emails.contact-enquiry-guest', [
                'enquiryTypeLine' => $enquiryTypeLine,
            ]);
    }
}
