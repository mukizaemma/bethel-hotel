<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Slide extends Model
{
    use HasFactory;
    
    protected $table = 'slides';

    protected $fillable = [
        'heading',
        'subheading',
        'button',
        'link',
        'image',
        'media_type',
        'video_url',
        'video_file',
    ];

    /**
     * Public URL for a slide image, resolving legacy and CMS storage paths.
     */
    public function imageUrl(): ?string
    {
        if (($this->media_type ?? 'image') !== 'image') {
            return null;
        }

        $raw = trim((string) ($this->image ?? ''));
        if ($raw === '') {
            return null;
        }

        if (str_starts_with($raw, 'http://') || str_starts_with($raw, 'https://')) {
            return $raw;
        }

        if (str_starts_with($raw, 'assets/')) {
            return asset($raw);
        }

        $path = ltrim($raw, '/');
        $basename = basename($path);

        foreach ([$path, 'slides/'.$basename, 'images/slides/'.$basename] as $candidate) {
            if (Storage::disk('public')->exists($candidate)) {
                return asset('storage/'.$candidate);
            }
        }

        return asset('storage/images/slides/'.$basename);
    }
}
