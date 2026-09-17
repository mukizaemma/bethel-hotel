<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facility;
use App\Models\Facilityimage;
use App\Models\Booking;
use App\Services\MediaLibrary;
use Illuminate\Support\Str;

class FacilityManagementController extends Controller
{
    public function __construct(protected MediaLibrary $mediaLibrary)
    {
    }

    public function index()
    {
        $facilities = Facility::with('images')->latest()->get();
        $facilityReservations = Booking::where('reservation_type', 'facility')
            ->with('facility')
            ->latest()
            ->get();

        return view('content-management.facilities.index', compact('facilities', 'facilityReservations'));
    }

    public function store(Request $request)
    {
        $request->validate($this->rules());

        $facility = new Facility();
        $facility->title = $request->title;
        $facility->slug = Str::slug($request->title);
        $facility->description = $request->description;
        $facility->status = $request->status;
        $facility->added_by = auth()->id();
        $this->applyCover($request, $facility);
        $facility->save();
        $this->attachGalleryImages($request, $facility);

        return response()->json(['success' => true, 'message' => 'Facility created successfully']);
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->rules());

        $facility = Facility::findOrFail($id);
        $facility->title = $request->title;
        $facility->slug = Str::slug($request->title);
        $facility->description = $request->description;
        $facility->status = $request->status;
        $this->applyCover($request, $facility);
        $facility->save();
        $this->attachGalleryImages($request, $facility);

        return response()->json(['success' => true, 'message' => 'Facility updated successfully']);
    }

    public function destroy($id)
    {
        $facility = Facility::findOrFail($id);
        foreach ($facility->images as $image) {
            $image->delete();
        }
        $facility->delete();

        return response()->json(['success' => true, 'message' => 'Facility deleted successfully']);
    }

    public function show($id)
    {
        $facility = Facility::with('images')->findOrFail($id);
        return response()->json($facility);
    }

    public function deleteImage($id)
    {
        $image = Facilityimage::findOrFail($id);
        $image->delete();

        return response()->json(['success' => true, 'message' => 'Image deleted successfully']);
    }

    public function addImages(Request $request, $id)
    {
        $request->validate([
            'images.*' => 'nullable|image|max:10240',
            'existing_media_ids' => 'nullable|array',
            'existing_media_ids.*' => 'integer|exists:media_images,id',
        ]);

        $facility = Facility::findOrFail($id);
        $this->attachGalleryImages($request, $facility);

        return response()->json(['success' => true, 'message' => 'Images added successfully']);
    }

    protected function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:10240',
            'existing_cover_media_id' => 'nullable|integer|exists:media_images,id',
            'existing_media_ids' => 'nullable|array',
            'existing_media_ids.*' => 'integer|exists:media_images,id',
            'status' => 'required|in:Active,Inactive',
            'images.*' => 'nullable|image|max:10240',
        ];
    }

    protected function applyCover(Request $request, Facility $facility): void
    {
        if ($request->hasFile('cover_image')) {
            $media = $this->mediaLibrary->ingestUploadedFile($request->file('cover_image'), 'facilities');
            $facility->cover_image = $media->path;

            return;
        }

        if ($request->filled('existing_cover_media_id')) {
            $cover = $this->mediaLibrary->findMany([(int) $request->input('existing_cover_media_id')])->first();
            if ($cover) {
                $facility->cover_image = $cover->path;
            }
        }
    }

    protected function attachGalleryImages(Request $request, Facility $facility): void
    {
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if (! $image || ! $image->isValid()) {
                    continue;
                }
                $media = $this->mediaLibrary->ingestUploadedFile($image, 'facilities/gallery');
                $this->addFacilityImageIfMissing($facility, $media->path);
            }
        }

        foreach ($this->mediaLibrary->findMany((array) $request->input('existing_media_ids', [])) as $media) {
            $this->addFacilityImageIfMissing($facility, $media->path);
        }
    }

    protected function addFacilityImageIfMissing(Facility $facility, string $path): void
    {
        $exists = Facilityimage::query()->where('facility_id', $facility->id)->where('image', $path)->exists();
        if ($exists) {
            return;
        }

        Facilityimage::create([
            'facility_id' => $facility->id,
            'image' => $path,
        ]);
    }
}
