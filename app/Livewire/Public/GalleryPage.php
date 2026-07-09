<?php

namespace App\Livewire\Public;

use App\Models\Facility;
use App\Models\Facilityimage;
use App\Models\Gallery;
use App\Models\Room;
use App\Models\Roomimage;
use App\Services\PublicWebsiteData;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.frontbase')]
class GalleryPage extends Component
{
    /** @var array<int, array{id:string,url:string,caption:string,category:string}> */
    public array $galleryImages = [];

    public bool $galleryHasMore = true;

    public int $galleryBatchSize = 12;

    public bool $loadingGallery = false;

    public function mount(): void
    {
        $this->galleryImages = [];
        $this->galleryHasMore = true;
        $this->loadMoreGalleryImages();
    }

    public function loadMoreGalleryImages(): void
    {
        if (! $this->galleryHasMore || $this->loadingGallery) {
            return;
        }

        $this->loadingGallery = true;

        try {
            $allItems = $this->buildGalleryItems();
            $offset = count($this->galleryImages);
            $batch = array_slice($allItems, $offset, $this->galleryBatchSize);

            foreach ($batch as $item) {
                $this->galleryImages[] = $item;
            }

            $this->galleryHasMore = ($offset + count($batch)) < count($allItems);
        } finally {
            $this->loadingGallery = false;
        }
    }

    /**
     * @return array<int, array{id:string,url:string,caption:string,category:string}>
     */
    protected function buildGalleryItems(): array
    {
        $items = [];
        $seenUrls = [];

        $push = function (string $id, string $url, string $caption, string $category) use (&$items, &$seenUrls): void {
            $url = trim($url);
            if ($url === '' || isset($seenUrls[$url])) {
                return;
            }
            $seenUrls[$url] = true;
            $items[] = [
                'id' => $id,
                'url' => $url,
                'caption' => $caption,
                'category' => $category,
            ];
        };

        Gallery::query()
            ->where('media_type', 'image')
            ->whereNotNull('image')
            ->where('image', '!=', '')
            ->oldest('id')
            ->get()
            ->each(function (Gallery $img) use ($push): void {
                $push(
                    'cms-'.$img->id,
                    $this->storageUrl($img->image, 'images/gallery'),
                    (string) ($img->caption ?? ''),
                    'Hotel'
                );
            });

        Room::query()
            ->where('status', 'Active')
            ->with('images')
            ->oldest('id')
            ->get()
            ->each(function (Room $room) use ($push): void {
                if (filled($room->cover_image)) {
                    $push(
                        'room-cover-'.$room->id,
                        $this->storageUrl($room->cover_image, 'rooms'),
                        $room->title.' — cover',
                        'Rooms'
                    );
                } elseif (filled($room->image)) {
                    $push(
                        'room-main-'.$room->id,
                        $this->storageUrl($room->image, 'images/rooms'),
                        $room->title,
                        'Rooms'
                    );
                }

                $room->images->each(function (Roomimage $img) use ($push, $room): void {
                    if (! filled($img->image)) {
                        return;
                    }
                    $push(
                        'room-img-'.$img->id,
                        $this->storageUrl($img->image, 'images/rooms'),
                        filled($img->caption) ? (string) $img->caption : $room->title,
                        'Rooms'
                    );
                });
            });

        Facility::query()
            ->where('status', 'Active')
            ->with('images')
            ->oldest('id')
            ->get()
            ->each(function (Facility $facility) use ($push): void {
                if (filled($facility->cover_image)) {
                    $push(
                        'facility-cover-'.$facility->id,
                        $this->storageUrl($facility->cover_image, 'facilities'),
                        $facility->title.' — cover',
                        'Facilities'
                    );
                } elseif (filled($facility->image)) {
                    $push(
                        'facility-main-'.$facility->id,
                        $this->storageUrl($facility->image, 'facilities'),
                        $facility->title,
                        'Facilities'
                    );
                }

                $facility->images->each(function (Facilityimage $img) use ($push, $facility): void {
                    if (! filled($img->image)) {
                        return;
                    }
                    $push(
                        'facility-img-'.$img->id,
                        $this->storageUrl($img->image, 'facilities'),
                        filled($img->caption) ? (string) $img->caption : $facility->title,
                        'Facilities'
                    );
                });
            });

        return $items;
    }

    protected function storageUrl(?string $path, string $legacyPrefix): string
    {
        $path = ltrim((string) $path, '/');
        if ($path === '') {
            return '';
        }

        if (str_contains($path, '/') || str_starts_with($path, 'gallery/') || str_starts_with($path, 'rooms/') || str_starts_with($path, 'facilities/')) {
            return asset('storage/'.$path);
        }

        return asset('storage/'.trim($legacyPrefix, '/').'/'.$path);
    }

    public function render()
    {
        return view('frontend.gallery', array_merge(
            PublicWebsiteData::galleryPageStatic(),
            [
                'rooms' => Room::where('status', 'Active')->oldest()->get(),
            ]
        ));
    }
}
