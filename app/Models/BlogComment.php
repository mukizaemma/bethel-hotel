<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    use HasFactory;

    protected $table = 'blog_comments';

    protected $fillable = [
        'blog_id',
        'added_by',
        'names',
        'email',
        'comment',
        'status',
        'published_at',
    ];  

    public function blog(){
        return $this->belongsTo(Blog::class,'blog_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'created_by');
    }
    
    
}
