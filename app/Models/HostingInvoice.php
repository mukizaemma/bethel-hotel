<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HostingInvoice extends Model
{
    protected $fillable = [
        'invoice_number',
        'period_start',
        'period_end',
        'hosting_label',
        'hosting_usd',
        'hosting_amount_rwf',
        'support_amount_rwf',
        'usd_to_rwf_rate',
        'total_rwf',
        'status',
        'issued_on',
        'paid_at',
        'prepared_by',
    ];

    protected $casts = [
        'period_start' => 'date',
        'period_end' => 'date',
        'issued_on' => 'date',
        'paid_at' => 'datetime',
        'hosting_usd' => 'float',
        'hosting_amount_rwf' => 'integer',
        'support_amount_rwf' => 'integer',
        'usd_to_rwf_rate' => 'float',
        'total_rwf' => 'integer',
    ];

    public function reminders(): HasMany
    {
        return $this->hasMany(HostingReminder::class);
    }

    public function periodLabel(): string
    {
        return $this->period_start->format('d F Y').' – '.$this->period_end->format('d F Y');
    }

    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    public function supportLabel(): string
    {
        if ((int) $this->support_amount_rwf === 0) {
            return 'Free';
        }

        return number_format((int) $this->support_amount_rwf);
    }

    public function hostingAmountLabel(): string
    {
        if ($this->hosting_amount_rwf !== null) {
            return number_format((int) $this->hosting_amount_rwf);
        }

        if ($this->hosting_usd) {
            return '$'.rtrim(rtrim(number_format((float) $this->hosting_usd, 2), '0'), '.').' × rate';
        }

        return '—';
    }

    public function totalLabel(): string
    {
        if ($this->total_rwf === null) {
            return 'Set the dollar rate';
        }

        return number_format((int) $this->total_rwf);
    }
}
