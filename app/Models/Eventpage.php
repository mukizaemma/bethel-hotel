<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eventpage extends Model
{
    use HasFactory;
    protected $table = 'eventpages';

    protected $fillable = [
        'title',
        'description',
        'details',
        'image',
    ];
    public function images()
    {
        return $this->hasMany(Eventimage::class)->orderBy('sort_order')->orderBy('id');
    }

    public function meetingRooms()
    {
        return $this->hasMany(MeetingRoom::class)->orderBy('sort_order')->orderBy('id');
    }
}
