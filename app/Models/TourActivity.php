<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'cover_image',
        'description',
        'status',
        'added_by',
    ];

    public function images(){
        return $this->hasMany(TourActivityImage::class);
    }

    public function addedBy(){
        return $this->belongsTo(User::class, 'added_by');
    }
}
