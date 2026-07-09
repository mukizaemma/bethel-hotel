<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;
    
    protected $table = 'restaurants';

    protected $fillable = [
        'title',
        'description',
        'image',
        'cuisine_section_title',
        'cuisine_section_lead',
    ];

    public function images()
    {
        return $this->hasMany(Restoimage::class)->orderBy('sort_order')->orderBy('id');
    }

    public function cuisines()
    {
        return $this->hasMany(RestaurantCuisine::class)->orderBy('sort_order')->orderBy('id');
    }
}
