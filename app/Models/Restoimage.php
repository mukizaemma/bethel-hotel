<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restoimage extends Model
{
    use HasFactory;
    protected $table = 'restoimages';

    protected $fillable = [
        'image',
        'caption',
        'sort_order',
        'restaurant_id',
        'user_id',
    ];

    public function restorant(){
    return $this->belongsTo(Restaurant::class);
    }
}
