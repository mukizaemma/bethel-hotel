<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'names',
        'phone',
        'email',
        'arrival_date',
        'date_in',
        'checkin_date',
        'checkout_date',
        'guests',
        'status',
        'facility_id',
        'trip_id',
        'room_id',
        'total_amount',
        'paid_amount',
        'balance_amount',
        'payment_status',
        'booking_type',
    ];

    protected $casts = [
        'arrival_date' => 'date',
        'date_in' => 'date',
        'checkin_date' => 'date',
        'checkout_date' => 'date',
    ];

    public function room(){
        return $this->belongsTo(Room::class);
    }

    public function facility(){
        return $this->belongsTo(Facility::class);
    }

    public function trip(){
        return $this->belongsTo(Trip::class);
    }
}
