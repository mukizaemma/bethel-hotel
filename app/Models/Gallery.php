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
            'media_image_id',
            'category',
            'caption',
            'image',
            'video_path',
            'youtube_link',
            'thumbnail',
            'sort_order',
        ];

    public function mediaImage()
    {
        return $this->belongsTo(MediaImage::class);
    }

    public function scopeOrdered($query)
    {
        return $query->orderByDesc('sort_order')->orderByDesc('created_at')->orderByDesc('id');
    }

    public function publicUrl(): string
    {
        if ($this->mediaImage && $this->mediaImage->path) {
            return $this->mediaImage->url();
        }

        $path = ltrim((string) $this->image, '/');
        if ($path === '') {
            return '';
        }
        if (str_contains($path, '/')) {
            return asset('storage/'.$path);
        }

        return asset('storage/images/gallery/'.$path);
    }

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
