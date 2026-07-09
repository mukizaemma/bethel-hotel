<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subTitle',
        'founderDescription',
        'mission',
        'vision',
        'storyDescription',
        'image1',
        'image2',
        'image3',
        'image4',
        'storyImage',
        'backImageText',
        'user_id',
    ];
}
