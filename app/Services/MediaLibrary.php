<?php

namespace App\Services;

use App\Models\Facility;
use App\Models\Facilityimage;
use App\Models\Gallery;
use App\Models\MediaImage;
use App\Models\PageHero;
use App\Models\Room;
use App\Models\Roomimage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class MediaLibrary
{
    public function __construct(protected ImageOptimizer $optimizer)
    {
    }

    public function ingestUploadedFile(UploadedFile $file, string $directory = 'media'): MediaImage
    {
        $path = $this->optimizer->store($file, $directory);

        return $this->registerStoredPath(
            $path,
            $file->getClientOriginalName()
        );
    }

    public function ingestStoredPath(string $path, ?string $originalName = null): ?MediaImage
    {
        $resolved = $this->resolvePublicPath($path);
        if ($resolved === null) {
            return null;
        }

        return $this->registerStoredPath($resolved, $originalName ?: basename($resolved));
    }

    /**
     * @param  array<int, mixed>  $ids
     * @return Collection<int, MediaImage>
     */
    public function findMany(array $ids): Collection
    {
        $ids = array_values(array_unique(array_filter(array_map('intval', $ids))));
        if ($ids === []) {
            return collect();
        }

        return MediaImage::query()->whereIn('id', $ids)->get();
    }

    public function attachToGallery(MediaImage $media, ?string $caption = null, ?string $category = null): Gallery
    {
        $existing = Gallery::query()
            ->where('media_type', 'image')
            ->where(function ($q) use ($media) {
                $q->where('media_image_id', $media->id)
                    ->orWhere('image', $media->path);
            })
            ->first();

        if ($existing) {
            return $existing;
        }

        $max = (int) Gallery::query()->max('sort_order');

        return Gallery::create([
            'media_type' => 'image',
            'media_image_id' => $media->id,
            'image' => $media->path,
            'caption' => $caption,
            'category' => $category,
            'sort_order' => $max + 1,
        ]);
    }

    /**
     * Import existing room, facility, and gallery files into the media library
     * and ensure the public gallery has one row per unique image.
     */
    public function importExistingContent(): void
    {
        $seenHashes = [];

        $register = function (string $path) use (&$seenHashes): ?MediaImage {
            $media = $this->ingestStoredPath($path);
            if (! $media) {
                return null;
            }
            $seenHashes[$media->hash] = $media;

            return $media;
        };

        Gallery::query()->where('media_type', 'image')->whereNotNull('image')->where('image', '!=', '')
            ->orderByDesc('id')
            ->get()
            ->each(function (Gallery $item) use ($register) {
                $media = $register((string) $item->image);
                if (! $media) {
                    return;
                }
                if (! $item->media_image_id) {
                    $item->media_image_id = $media->id;
                    $item->image = $media->path;
                    if (! $item->sort_order) {
                        $item->sort_order = (int) $item->id;
                    }
                    $item->save();
                }
            });

        Room::query()->get()->each(function (Room $room) use ($register) {
            foreach ([$room->cover_image, $room->image] as $path) {
                if (filled($path)) {
                    $register((string) $path);
                }
            }
        });

        Roomimage::query()->get()->each(function (Roomimage $img) use ($register) {
            if (filled($img->image)) {
                $register((string) $img->image);
            }
        });

        Facility::query()->get()->each(function (Facility $facility) use ($register) {
            foreach ([$facility->cover_image, $facility->image] as $path) {
                if (filled($path)) {
                    $register((string) $path);
                }
            }
        });

        Facilityimage::query()->get()->each(function (Facilityimage $img) use ($register) {
            if (filled($img->image)) {
                $register((string) $img->image);
            }
        });

        PageHero::query()->get()->each(function (PageHero $hero) use ($register) {
            if (filled($hero->background_image)) {
                $register((string) $hero->background_image);
            }
        });

        $this->dedupeGalleryRows();

        foreach ($seenHashes as $media) {
            $this->attachToGallery($media);
        }

        $this->normalizeGallerySortOrder();
    }

    public function dedupeGalleryRows(): int
    {
        $removed = 0;
        $seen = [];
        Gallery::query()
            ->where('media_type', 'image')
            ->orderByDesc('id')
            ->get()
            ->each(function (Gallery $item) use (&$seen, &$removed) {
                $key = $item->media_image_id ? 'id:'.$item->media_image_id : 'path:'.$item->image;
                if (isset($seen[$key])) {
                    $item->delete();
                    $removed++;

                    return;
                }
                $seen[$key] = true;
            });

        return $removed;
    }

    public function normalizeGallerySortOrder(): void
    {
        $items = Gallery::query()->orderByDesc('sort_order')->orderByDesc('created_at')->orderByDesc('id')->get();
        $count = $items->count();
        foreach ($items as $index => $item) {
            $item->sort_order = $count - $index;
            $item->save();
        }
    }

    protected function registerStoredPath(string $path, string $originalName): MediaImage
    {
        $full = Storage::disk('public')->path($path);
        $hash = is_file($full) ? (string) md5_file($full) : md5($path);
        $existing = MediaImage::query()->where('hash', $hash)->first();
        if ($existing) {
            if ($existing->path !== $path) {
                Storage::disk('public')->delete($path);
            }

            return $existing;
        }

        return MediaImage::create([
            'path' => $path,
            'original_name' => $originalName,
            'mime' => Storage::disk('public')->exists($path) ? Storage::disk('public')->mimeType($path) : null,
            'size' => Storage::disk('public')->exists($path) ? Storage::disk('public')->size($path) : 0,
            'hash' => $hash,
        ]);
    }

    public function resolvePublicPath(string $path): ?string
    {
        $path = ltrim($path, '/');
        if ($path === '') {
            return null;
        }

        if (Storage::disk('public')->exists($path)) {
            return $path;
        }

        foreach (['images/gallery/'.$path, 'gallery/'.$path, 'images/rooms/'.$path, 'rooms/'.$path, 'facilities/'.$path, 'page-heroes/'.$path] as $candidate) {
            if (Storage::disk('public')->exists($candidate)) {
                return $candidate;
            }
        }

        return null;
    }
}
