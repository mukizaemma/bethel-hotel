<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HostingProfile extends Model
{
    protected $fillable = [
        'registrar',
        'hosting_provider',
        'domain',
        'annual_hosting_usd',
        'annual_support_rwf',
        'usd_to_rwf_rate',
        'notify_email',
        'renewal_month',
        'renewal_day',
    ];

    protected $casts = [
        'annual_hosting_usd' => 'float',
        'annual_support_rwf' => 'integer',
        'usd_to_rwf_rate' => 'float',
        'renewal_month' => 'integer',
        'renewal_day' => 'integer',
    ];

    public static function current(): self
    {
        return static::query()->firstOrCreate([], [
            'registrar' => 'afriregister.com',
            'hosting_provider' => 'digitalocean.com',
            'domain' => 'www.bethelhotel.rw',
            'annual_hosting_usd' => 80,
            'annual_support_rwf' => 500000,
            'renewal_month' => 8,
            'renewal_day' => 1,
        ]);
    }

    public function notificationEmail(): string
    {
        $email = trim((string) $this->notify_email);
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $email;
        }

        return (string) config('mail.notification.admin_to', config('mail.from.address'));
    }
}
