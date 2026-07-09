<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourActivityImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_activity_id',
        'image',
        'caption',
        'order',
    ];

    public function tourActivity(){
        return $this->belongsTo(TourActivity::class);
    }
}
