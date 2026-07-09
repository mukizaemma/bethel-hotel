<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eventimage extends Model
{
    use HasFactory;
    protected $table = 'eventimages';

    protected $fillable = [
        'image',
        'caption',
        'sort_order',
        'eventpage_id',
        'user_id',
    ];

    public function event(){
    return $this->belongsTo(Eventpage::class);
    }
}
