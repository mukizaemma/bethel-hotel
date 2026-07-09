<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roomimage extends Model
{
    use HasFactory;
    protected $table = 'roomimages';

    protected $fillable = [
        'image','caption','room_id','user_id'
    ];

    public function gallery(){
    return $this->belongsTo(Room::class);
    }
}
