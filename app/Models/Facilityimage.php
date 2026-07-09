<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facilityimage extends Model
{
    use HasFactory;
    protected $table = 'facilityimages';

    protected $fillable = [
        'image','caption','facility_id','added_by'
    ];

    public function facility(){
    return $this->belongsTo(Facility::class);
    }
}
