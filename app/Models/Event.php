<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $table='events';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'date',
        'time',
        'venue',
        'fees',
        'image',
        'status',
        'user_id',
        'published_at',
        'published_by',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
