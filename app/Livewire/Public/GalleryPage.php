<?php

namespace App\Livewire\Public;

use App\Models\Gallery;
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
        $seen = [];

        Gallery::query()
            ->with('mediaImage')
            ->where('media_type', 'image')
            ->ordered()
            ->get()
            ->each(function (Gallery $img) use (&$items, &$seen): void {
                $url = $img->publicUrl();
                $key = $img->media_image_id ? 'media-'.$img->media_image_id : $url;
                if ($url === '' || isset($seen[$key]) || isset($seen[$url])) {
                    return;
                }
                $seen[$key] = true;
                $seen[$url] = true;
                $items[] = [
                    'id' => 'cms-'.$img->id,
                    'url' => $url,
                    'caption' => (string) ($img->caption ?? ''),
                    'category' => (string) ($img->category ?: 'Hotel'),
                ];
            });

        return $items;
    }

    public function render()
    {
        return view('frontend.gallery', PublicWebsiteData::galleryPageStatic());
    }
}
