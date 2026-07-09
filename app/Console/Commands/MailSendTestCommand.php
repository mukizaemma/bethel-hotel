<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class MailSendTestCommand extends Command
{
    protected $signature = 'mail:test 
                            {to? : Email address to receive the test (defaults to MAIL_NOTIFICATION_TO)}';

    protected $description = 'Send a one-line test email via the configured mailer (use on production to verify Resend).';

    public function handle(): int
    {
        $this->line('Default mailer: '.config('mail.default'));
        $this->line('From: '.config('mail.from.address').' ('.config('mail.from.name').')');

        $key = config('resend.api_key') ?? config('services.resend.key');
        $this->line('RESEND_API_KEY: '.(is_string($key) && $key !== '' ? 'set ('.strlen($key).' chars)' : 'MISSING — add to .env and run php artisan config:clear'));

        $to = $this->argument('to') ?: config('mail.notification.admin_to');
        if ($to === '' || $to === null) {
            $this->error('No recipient. Set MAIL_NOTIFICATION_TO in .env or pass an email: php artisan mail:test you@example.com');

            return self::FAILURE;
        }

        $this->line('Sending test to: '.$to);

        try {
            Mail::raw('Mail test from '.config('app.url').' at '.now()->toIso8601String(), function ($message) use ($to) {
                $message->to($to)
                    ->subject('Bethel Hotel site — mail test');
            });
        } catch (\Throwable $e) {
            $this->error('Send failed: '.$e->getMessage());
            $this->line('Check storage/logs/laravel.log and Resend dashboard (Domains, API keys).');

            return self::FAILURE;
        }

        $this->info('Sent. Check the inbox (and spam) for: '.$to);

        return self::SUCCESS;
    }
}
