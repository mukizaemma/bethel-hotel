<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;
    protected $table='programs';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'status',
        'user_id',
    ];

    public function posts(){
        return $this->hasMany(Post::class);
    }

}
