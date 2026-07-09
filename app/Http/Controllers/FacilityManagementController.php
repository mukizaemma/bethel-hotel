<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facility;
use App\Models\Facilityimage;
use App\Models\Booking;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class FacilityManagementController extends Controller
{
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
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:2048',
            'status' => 'required|in:Active,Inactive',
            'images.*' => 'nullable|image|max:2048',
        ]);

        $facility = new Facility();
        $facility->title = $request->title;
        $facility->slug = Str::slug($request->title);
        $facility->description = $request->description;
        $facility->status = $request->status;
        $facility->added_by = auth()->id();

        if ($request->hasFile('cover_image')) {
            $facility->cover_image = $request->file('cover_image')->store('facilities', 'public');
        }

        $facility->save();

        // Handle gallery images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                Facilityimage::create([
                    'facility_id' => $facility->id,
                    'image' => $image->store('facilities/gallery', 'public'),
                ]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Facility created successfully']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:2048',
            'status' => 'required|in:Active,Inactive',
            'images.*' => 'nullable|image|max:2048',
        ]);

        $facility = Facility::findOrFail($id);
        $facility->title = $request->title;
        $facility->slug = Str::slug($request->title);
        $facility->description = $request->description;
        $facility->status = $request->status;

        if ($request->hasFile('cover_image')) {
            if ($facility->cover_image) {
                Storage::disk('public')->delete($facility->cover_image);
            }
            $facility->cover_image = $request->file('cover_image')->store('facilities', 'public');
        }

        $facility->save();

        // Handle new gallery images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                Facilityimage::create([
                    'facility_id' => $facility->id,
                    'image' => $image->store('facilities/gallery', 'public'),
                ]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Facility updated successfully']);
    }

    public function destroy($id)
    {
        $facility = Facility::findOrFail($id);
        
        // Delete cover image
        if ($facility->cover_image) {
            Storage::disk('public')->delete($facility->cover_image);
        }

        // Delete gallery images
        foreach ($facility->images as $image) {
            Storage::disk('public')->delete($image->image);
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
        Storage::disk('public')->delete($image->image);
        $image->delete();

        return response()->json(['success' => true, 'message' => 'Image deleted successfully']);
    }

    public function addImages(Request $request, $id)
    {
        $request->validate([
            'images.*' => 'required|image|max:2048',
        ]);

        $facility = Facility::findOrFail($id);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                Facilityimage::create([
                    'facility_id' => $facility->id,
                    'image' => $image->store('facilities/gallery', 'public'),
                ]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Images added successfully']);
    }
}
