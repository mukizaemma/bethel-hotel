<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingTrash extends Model
{
    use HasFactory;

    protected $table = 'booking_trashes';

    protected $fillable = [
        'original_booking_id',
        'names',
        'email',
        'phone',
        'reservation_type',
        'status',
        'payload',
    ];

    protected $casts = [
        'payload' => 'array',
    ];
}

