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
        try {
            $pending = Mail::to($to);
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
        try {
            Mail::to($email)->send($mailable);

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
