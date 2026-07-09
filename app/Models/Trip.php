<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;
    protected $table='trips';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'itinerary',
        'expectations',
        'recommendations',
        'inclusions',
        'exclusions',
        'location',
        'duration',
        'languages',
        'currency',
        'maxPeople',
        'minAge',
        'price',
        'couplePrice',
        'image',
        'status',
        'added_by',
    ];

    public function images(){
        return $this->hasMany(Tripimage::class);
    }
}
