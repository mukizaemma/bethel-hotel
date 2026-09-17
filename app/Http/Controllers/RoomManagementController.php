<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Amenity;
use App\Models\Room;
use App\Models\Roomimage;
use App\Models\Setting;
use App\Services\MediaLibrary;
use Illuminate\Support\Str;

class RoomManagementController extends Controller
{
    public function __construct(protected MediaLibrary $mediaLibrary)
    {
    }

    public function index()
    {
        $rooms = Room::with(['amenities', 'images'])->latest()->get();
        $amenities = Amenity::all();
        $setting = Setting::first();

        return view('content-management.rooms.index', compact('rooms', 'amenities', 'setting'));
    }

    public function store(Request $request)
    {
        $request->validate($this->rules());

        $included = (int) $request->guests_included_in_price;
        $maxOcc = max($included, 1);

        $room = new Room();
        $room->title = $request->title;
        $room->slug = Str::slug($request->title);
        $room->room_number = $request->room_number;
        $room->description = $request->description;
        $room->category = $request->category;
        $room->room_type = 'room';
        $room->number_of_rooms = (int) $request->input('number_of_rooms', 1);
        $room->price = $request->price;
        $room->couplePrice = null;
        $room->guests_included_in_price = $included;
        $room->extra_adult_price = $request->filled('extra_adult_price') ? $request->extra_adult_price : null;
        $room->extra_child_price = $request->filled('extra_child_price') ? $request->extra_child_price : null;
        $room->extra_bed_price = $request->filled('extra_bed_price') ? $request->extra_bed_price : null;
        $room->max_occupancy = $maxOcc;
        $room->bed_count = 1;
        $room->bed_type = null;
        $room->status = $request->status;
        $room->room_status = $request->room_status;
        $room->user_id = auth()->id();
        $this->applyCover($request, $room);
        $room->save();

        if ($request->has('amenities')) {
            $room->amenities()->sync($request->amenities);
        }

        $this->attachGalleryImages($request, $room);

        return response()->json(['success' => true, 'message' => 'Room created successfully']);
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->rules($id));

        $room = Room::findOrFail($id);
        $preservedCouplePrice = $room->couplePrice;
        $preservedBedCount = $room->bed_count;
        $preservedBedType = $room->bed_type;

        $included = (int) $request->guests_included_in_price;
        $maxOcc = max($included, 1);

        $room->title = $request->title;
        $room->slug = Str::slug($request->title);
        $room->room_number = $request->room_number;
        $room->description = $request->description;
        $room->category = $request->category;
        $room->room_type = 'room';
        $room->number_of_rooms = (int) $request->input('number_of_rooms', 1);
        $room->price = $request->price;
        $room->couplePrice = $preservedCouplePrice;
        $room->guests_included_in_price = $included;
        $room->extra_adult_price = $request->filled('extra_adult_price') ? $request->extra_adult_price : null;
        $room->extra_child_price = $request->filled('extra_child_price') ? $request->extra_child_price : null;
        $room->extra_bed_price = $request->filled('extra_bed_price') ? $request->extra_bed_price : null;
        $room->max_occupancy = $maxOcc;
        $room->bed_count = $preservedBedCount;
        $room->bed_type = $preservedBedType;
        $room->status = $request->status;
        $room->room_status = $request->room_status;
        $this->applyCover($request, $room);
        $room->save();

        if ($request->has('amenities')) {
            $room->amenities()->sync($request->amenities);
        } else {
            $room->amenities()->detach();
        }

        $this->attachGalleryImages($request, $room);

        return response()->json(['success' => true, 'message' => 'Room updated successfully']);
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        foreach ($room->images as $image) {
            $image->delete();
        }
        $room->delete();

        return response()->json(['success' => true, 'message' => 'Room deleted successfully']);
    }

    public function show($id)
    {
        $room = Room::with(['amenities', 'images'])->findOrFail($id);
        return response()->json($room);
    }

    public function deleteImage($id)
    {
        $image = Roomimage::findOrFail($id);
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

        $room = Room::findOrFail($id);
        $this->attachGalleryImages($request, $room);

        return response()->json(['success' => true, 'message' => 'Images added successfully']);
    }

    protected function rules(?int $id = null): array
    {
        return [
            'title' => 'required|string|max:255',
            'room_number' => 'nullable|string|max:255|unique:rooms,room_number'.($id ? ','.$id : ''),
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:10240',
            'existing_cover_media_id' => 'nullable|integer|exists:media_images,id',
            'existing_media_ids' => 'nullable|array',
            'existing_media_ids.*' => 'integer|exists:media_images,id',
            'category' => 'nullable|string',
            'number_of_rooms' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'guests_included_in_price' => 'required|integer|min:1',
            'extra_adult_price' => 'nullable|numeric|min:0',
            'extra_child_price' => 'nullable|numeric|min:0',
            'extra_bed_price' => 'nullable|numeric|min:0',
            'status' => 'required|in:Active,Inactive',
            'room_status' => 'required|in:available,occupied,reserved,maintenance',
            'amenities' => 'nullable|array',
            'amenities.*' => 'exists:amenities,id',
            'images.*' => 'nullable|image|max:10240',
        ];
    }

    protected function applyCover(Request $request, Room $room): void
    {
        if ($request->hasFile('cover_image')) {
            $media = $this->mediaLibrary->ingestUploadedFile($request->file('cover_image'), 'rooms');
            $room->cover_image = $media->path;

            return;
        }

        if ($request->filled('existing_cover_media_id')) {
            $cover = $this->mediaLibrary->findMany([(int) $request->input('existing_cover_media_id')])->first();
            if ($cover) {
                $room->cover_image = $cover->path;
            }
        }
    }

    protected function attachGalleryImages(Request $request, Room $room): void
    {
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if (! $image || ! $image->isValid()) {
                    continue;
                }
                $media = $this->mediaLibrary->ingestUploadedFile($image, 'rooms/gallery');
                $this->addRoomImageIfMissing($room, $media->path);
            }
        }

        foreach ($this->mediaLibrary->findMany((array) $request->input('existing_media_ids', [])) as $media) {
            $this->addRoomImageIfMissing($room, $media->path);
        }
    }

    protected function addRoomImageIfMissing(Room $room, string $path): void
    {
        $exists = Roomimage::query()->where('room_id', $room->id)->where('image', $path)->exists();
        if ($exists) {
            return;
        }

        Roomimage::create([
            'room_id' => $room->id,
            'image' => $path,
        ]);
    }
}
