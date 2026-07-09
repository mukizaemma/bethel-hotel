<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone',
        'email',
        'address',
        'city',
        'country',
        'postal_code',
        'website',
        'facebook',
        'twitter',
        'instagram',
        'linkedin',
        'whatsapp',
        'latitude',
        'longitude',
    ];
}
