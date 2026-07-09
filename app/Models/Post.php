<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $table='posts';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'applicationLink',
        'image',
        'status',
        'user_id',
        'program_id',
    ];

    public function program(){
        return $this->belongsTo(Program::class);
    }
}
