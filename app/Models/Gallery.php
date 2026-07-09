<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;
        protected $table = "galleries";

        protected $fillable = [
            'media_type',
            'category',
            'caption',
            'image',
            'video_path',
            'youtube_link',
            'thumbnail',
        ];

    /**
     * Get YouTube video ID from youtube_link for embedding.
     */
    public function getYoutubeVideoIdAttribute(): ?string
    {
        if (empty($this->youtube_link)) {
            return null;
        }
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $this->youtube_link, $m)) {
            return $m[1];
        }
        return null;
    }
}
