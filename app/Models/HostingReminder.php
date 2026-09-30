<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HostingReminder extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'hosting_invoice_id',
        'milestone',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(HostingInvoice::class, 'hosting_invoice_id');
    }
}
