<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MediaImage extends Model
{
    protected $fillable = [
        'path',
        'original_name',
        'mime',
        'size',
        'hash',
    ];

    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class);
    }

    public function url(): string
    {
        return asset('storage/'.ltrim((string) $this->path, '/'));
    }

    public function sizeKb(): int
    {
        return (int) ceil(((int) $this->size) / 1024);
    }
}
