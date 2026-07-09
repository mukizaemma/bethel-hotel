<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tripimage extends Model
{
    use HasFactory;
    protected $table = 'tripimages';

    protected $fillable = [
        'image','caption','trip_id','added_by'
    ];

    public function trip(){
    return $this->belongsTo(Trip::class);
    }
}
