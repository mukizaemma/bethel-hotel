<?php

namespace App\Http\Controllers;

use App\Models\Facilityimage;
use App\Models\Gallery;
use App\Models\MediaImage;
use App\Models\Roomimage;
use App\Services\MediaLibrary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MediaLibraryController extends Controller
{
    public function __construct(protected MediaLibrary $mediaLibrary)
    {
    }

    public function index()
    {
        $images = MediaImage::query()->latest()->get();
        $duplicateGroups = MediaImage::query()
            ->select('hash', DB::raw('COUNT(*) as copies'))
            ->groupBy('hash')
            ->having('copies', '>', 1)
            ->pluck('copies', 'hash');

        $duplicateCount = (int) $duplicateGroups->sum();
        $galleryDuplicateCount = $this->galleryDuplicateCount();

        return view('content-management.media.index', compact(
            'images',
            'duplicateGroups',
            'duplicateCount',
            'galleryDuplicateCount'
        ));
    }

    public function json()
    {
        $images = MediaImage::query()->latest()->get()->map(function (MediaImage $image) {
            return [
                'id' => $image->id,
                'url' => $image->url(),
                'name' => $image->original_name,
                'size_kb' => $image->sizeKb(),
            ];
        });

        return response()->json(['images' => $images]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'images' => 'required',
            'images.*' => 'image|max:10240',
        ]);

        $files = $request->file('images', []);
        if (! is_array($files)) {
            $files = [$files];
        }

        $count = 0;
        $reused = 0;
        foreach ($files as $file) {
            if (! $file || ! $file->isValid()) {
                continue;
            }
            $before = MediaImage::query()->count();
            $this->mediaLibrary->ingestUploadedFile($file);
            $after = MediaImage::query()->count();
            if ($after > $before) {
                $count++;
            } else {
                $reused++;
            }
        }

        if ($count === 0 && $reused === 0) {
            return redirect()->back()->with('error', 'Please select at least one valid image.');
        }

        $message = $count.' new image(s) added.';
        if ($reused > 0) {
            $message .= ' '.$reused.' already existed in the library and were not duplicated.';
        }

        return redirect()->back()->with('success', $message);
    }

    public function destroy($id)
    {
        $image = MediaImage::findOrFail($id);
        $this->deleteMediaRecord($image);

        return redirect()->back()->with('warning', 'Image removed from the media library.');
    }

    public function destroyDuplicates()
    {
        $removedMedia = 0;
        MediaImage::query()
            ->select('hash')
            ->groupBy('hash')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('hash')
            ->each(function (string $hash) use (&$removedMedia) {
                $copies = MediaImage::query()->where('hash', $hash)->orderBy('id')->get();
                $keep = $copies->shift();
                foreach ($copies as $copy) {
                    Gallery::query()->where('media_image_id', $copy->id)->update(['media_image_id' => $keep->id, 'image' => $keep->path]);
                    $this->deleteMediaRecord($copy, false);
                    $removedMedia++;
                }
            });

        $removedGallery = $this->mediaLibrary->dedupeGalleryRows();

        return redirect()->back()->with('success', 'Removed '.$removedMedia.' duplicate media record(s) and '.$removedGallery.' duplicate gallery item(s).');
    }

    protected function galleryDuplicateCount(): int
    {
        $seen = [];
        $dupes = 0;
        Gallery::query()->where('media_type', 'image')->get()->each(function (Gallery $item) use (&$seen, &$dupes) {
            $key = $item->media_image_id ? 'id:'.$item->media_image_id : 'path:'.$item->image;
            if (isset($seen[$key])) {
                $dupes++;

                return;
            }
            $seen[$key] = true;
        });

        return $dupes;
    }

    protected function deleteMediaRecord(MediaImage $image, bool $deleteFileIfUnused = true): void
    {
        Gallery::query()->where('media_image_id', $image->id)->update(['media_image_id' => null]);

        $path = $image->path;
        $image->delete();

        if (! $deleteFileIfUnused || ! $path) {
            return;
        }

        $stillUsed = MediaImage::query()->where('path', $path)->exists()
            || Gallery::query()->where('image', $path)->exists()
            || Roomimage::query()->where('image', $path)->exists()
            || Facilityimage::query()->where('image', $path)->exists();

        if (! $stillUsed) {
            Storage::disk('public')->delete($path);
        }
    }
}
