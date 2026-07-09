<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tourimage extends Model
{
    use HasFactory;

    protected $table = 'tourimages';

    protected $fillable = [
        'image','caption','tour_id','user_id'
    ];

    public function gallery(){
    return $this->belongsTo(Tour::class);
    }
}
