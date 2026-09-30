<?php

namespace App\Mail;

use App\Models\HostingInvoice;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class HostingRenewalMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public HostingInvoice $invoice,
        public string $milestone,
        public int $daysUntil
    ) {
    }

    public function build(): self
    {
        $subject = match ($this->milestone) {
            'd30' => 'Bethel Hotel hosting renewal — 30 days left',
            'd15' => 'Bethel Hotel hosting renewal — 15 days left',
            default => $this->daysUntil < 0
                ? 'Bethel Hotel hosting renewal is overdue'
                : 'Bethel Hotel hosting renewal is due today',
        };

        return $this->subject($subject)
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->view('emails.hosting-renewal', [
                'issuer' => config('hosting.issuer'),
                'payment' => config('hosting.payment'),
                'invoiceUrl' => route('content-management.hosting.show', $this->invoice),
            ]);
    }
}
