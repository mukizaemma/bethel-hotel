<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $table='blogs';

    protected $fillable = [
        'title',
        'slug',
        'body',
        'image',
        'status',
        'publish',
        'added_by',
        'likes_count',
        'published_at',
        'published_by',
        'created_by',
        'category_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function blogCategory(){
        return $this->belongsTo(Category::class);
    }

        // Method to count the likes
    public function likeCount()
    {
        return $this->likes()->count();
    }
    public function comments()
    {
        return $this->hasMany(BlogComment::class);
    }
        // Method to count the likes
    public function commentsCount()
    {
        return $this->likes()->count();
    }
        
    protected $casts = [
        'published_at' => 'date',
        'created_at' => 'date',
    ];
    
}
