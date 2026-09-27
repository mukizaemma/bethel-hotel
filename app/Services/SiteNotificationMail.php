<?php

namespace App\Services;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SiteNotificationMail
{
    public static function adminTo(): string
    {
        return (string) config('mail.notification.admin_to', config('mail.from.address'));
    }

    public static function adminCc(): ?string
    {
        $cc = config('mail.notification.admin_cc');

        return filled($cc) ? (string) $cc : null;
    }

    /**
     * Send to primary inbox + CC (team notifications).
     */
    public static function sendToTeam(Mailable $mailable): bool
    {
        $to = self::adminTo();
        if ($to === '') {
            Log::warning('Site notification: MAIL_NOTIFICATION_TO is empty.');

            return false;
        }
        if (config('mail.default') === 'resend') {
            $key = config('resend.api_key') ?? config('services.resend.key');
            if (! is_string($key) || $key === '') {
                Log::warning('Site notification: RESEND_API_KEY is missing.');

                return false;
            }
        }
        try {
            $pending = Mail::mailer(config('mail.default', 'resend'))->to($to);
            $cc = self::adminCc();
            if ($cc !== null && $cc !== '') {
                $pending->cc($cc);
            }
            $pending->send($mailable);

            return true;
        } catch (\Throwable $e) {
            Log::error('Site notification mail to team failed', [
                'message' => $e->getMessage(),
                'mailer' => config('mail.default'),
                'exception' => $e,
            ]);

            return false;
        }
    }

    public static function sendToGuest(string $email, Mailable $mailable): bool
    {
        $email = trim($email);
        if ($email === '' || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        if (config('mail.default') === 'resend') {
            $key = config('resend.api_key') ?? config('services.resend.key');
            if (! is_string($key) || $key === '') {
                Log::warning('Site notification: RESEND_API_KEY is missing.');

                return false;
            }
        }
        try {
            Mail::mailer(config('mail.default', 'resend'))->to($email)->send($mailable);

            return true;
        } catch (\Throwable $e) {
            Log::error('Site notification mail to guest failed', [
                'message' => $e->getMessage(),
                'mailer' => config('mail.default'),
                'email' => $email,
                'exception' => $e,
            ]);

            return false;
        }
    }
}
