<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Amenity;
use App\Models\Room;
use App\Models\Roomimage;
use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class RoomManagementController extends Controller
{
    public function index()
    {
        $rooms = Room::with(['amenities', 'images'])->latest()->get();
        $amenities = Amenity::all();
        $setting = Setting::first();

        return view('content-management.rooms.index', compact('rooms', 'amenities', 'setting'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'room_number' => 'nullable|string|max:255|unique:rooms,room_number',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:2048',
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
            'images.*' => 'nullable|image|max:2048',
        ]);

        $included = (int) $request->guests_included_in_price;
        $maxOcc = max($included, 1);

        $room = new Room();
        $room->title = $request->title;
        $room->slug = Str::slug($request->title);
        $room->room_number = $request->room_number;
        $room->description = $request->description;
        $room->category = $request->category;
        // Rooms management now always creates "room" records (not apartments).
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

        if ($request->hasFile('cover_image')) {
            $room->cover_image = $request->file('cover_image')->store('rooms', 'public');
        }

        $room->save();

        // Attach amenities
        if ($request->has('amenities')) {
            $room->amenities()->sync($request->amenities);
        }

        // Handle gallery images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                Roomimage::create([
                    'room_id' => $room->id,
                    'image' => $image->store('rooms/gallery', 'public'),
                ]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Room created successfully']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'room_number' => 'nullable|string|max:255|unique:rooms,room_number,' . $id,
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:2048',
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
            'images.*' => 'nullable|image|max:2048',
        ]);

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
        // Rooms management now always sets "room" type.
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

        if ($request->hasFile('cover_image')) {
            if ($room->cover_image) {
                Storage::disk('public')->delete($room->cover_image);
            }
            $room->cover_image = $request->file('cover_image')->store('rooms', 'public');
        }

        $room->save();

        // Sync amenities
        if ($request->has('amenities')) {
            $room->amenities()->sync($request->amenities);
        } else {
            $room->amenities()->detach();
        }

        // Handle new gallery images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                Roomimage::create([
                    'room_id' => $room->id,
                    'image' => $image->store('rooms/gallery', 'public'),
                ]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Room updated successfully']);
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        
        // Delete cover image
        if ($room->cover_image) {
            Storage::disk('public')->delete($room->cover_image);
        }

        // Delete gallery images
        foreach ($room->images as $image) {
            Storage::disk('public')->delete($image->image);
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
        Storage::disk('public')->delete($image->image);
        $image->delete();

        return response()->json(['success' => true, 'message' => 'Image deleted successfully']);
    }

    public function addImages(Request $request, $id)
    {
        $request->validate([
            'images.*' => 'required|image|max:2048',
        ]);

        $room = Room::findOrFail($id);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                Roomimage::create([
                    'room_id' => $room->id,
                    'image' => $image->store('rooms/gallery', 'public'),
                ]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Images added successfully']);
    }
}
