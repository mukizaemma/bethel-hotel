<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;
    protected $table = 'tours';

    protected $fillable = [
        'title','description','status','image','caption','user_id'
    ];

    public function images(){
    return $this->hasMany(Tourimage::class);
    }
}
