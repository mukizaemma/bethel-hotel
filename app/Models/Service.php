<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'cover_image',
        'status',
        'added_by',
    ];

    public function images(){
        return $this->hasMany(ServiceImage::class);
    }

    public function addedBy(){
        return $this->belongsTo(User::class, 'added_by');
    }
}
