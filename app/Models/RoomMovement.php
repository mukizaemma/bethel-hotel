<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'from_room_id',
        'to_room_id',
        'reason',
        'moved_by',
    ];

    public function booking(){
        return $this->belongsTo(Booking::class);
    }

    public function fromRoom(){
        return $this->belongsTo(Room::class, 'from_room_id');
    }

    public function toRoom(){
        return $this->belongsTo(Room::class, 'to_room_id');
    }

    public function movedBy(){
        return $this->belongsTo(User::class, 'moved_by');
    }
}
