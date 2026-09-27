<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TourActivity;
use App\Models\TourActivityImage;
use App\Services\MediaLibrary;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TourActivityController extends Controller
{
    public function index()
    {
        $activities = TourActivity::with('images')->latest()->get();
        return view('content-management.tour-activities.index', compact('activities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:10240',
            'existing_cover_media_id' => 'nullable|integer|exists:media_images,id',
            'status' => 'required|in:Active,Inactive',
            'images.*' => 'nullable|image|max:10240',
            'existing_media_ids' => 'nullable|array',
            'existing_media_ids.*' => 'integer|exists:media_images,id',
        ]);

        $mediaLibrary = app(MediaLibrary::class);
        $activity = new TourActivity();
        $activity->title = $request->title;
        $activity->slug = Str::slug($request->title);
        $activity->description = $request->description;
        $activity->status = $request->status;
        $activity->added_by = auth()->id();

        $cover = $mediaLibrary->pathFromRequest($request, 'cover_image', 'existing_cover_media_id', 'tour-activities');
        if ($cover) {
            $activity->cover_image = $cover;
        }

        $activity->save();

        foreach ($mediaLibrary->pathsFromRequest($request, 'images', 'existing_media_ids', 'tour-activities/gallery') as $index => $path) {
            TourActivityImage::create([
                'tour_activity_id' => $activity->id,
                'image' => $path,
                'order' => $index,
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Tour activity created successfully']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:10240',
            'existing_cover_media_id' => 'nullable|integer|exists:media_images,id',
            'status' => 'required|in:Active,Inactive',
            'images.*' => 'nullable|image|max:10240',
            'existing_media_ids' => 'nullable|array',
            'existing_media_ids.*' => 'integer|exists:media_images,id',
        ]);

        $mediaLibrary = app(MediaLibrary::class);
        $activity = TourActivity::findOrFail($id);
        $activity->title = $request->title;
        $activity->slug = Str::slug($request->title);
        $activity->description = $request->description;
        $activity->status = $request->status;

        $cover = $mediaLibrary->pathFromRequest($request, 'cover_image', 'existing_cover_media_id', 'tour-activities');
        if ($cover) {
            $activity->cover_image = $cover;
        }

        $activity->save();

        $order = (int) $activity->images()->max('order');
        foreach ($mediaLibrary->pathsFromRequest($request, 'images', 'existing_media_ids', 'tour-activities/gallery') as $path) {
            $order++;
            TourActivityImage::create([
                'tour_activity_id' => $activity->id,
                'image' => $path,
                'order' => $order,
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Tour activity updated successfully']);
    }

    public function destroy($id)
    {
        $activity = TourActivity::findOrFail($id);
        
        // Delete cover image
        if ($activity->cover_image) {
            Storage::disk('public')->delete($activity->cover_image);
        }

        // Delete gallery images
        foreach ($activity->images as $image) {
            Storage::disk('public')->delete($image->image);
            $image->delete();
        }

        $activity->delete();

        return response()->json(['success' => true, 'message' => 'Tour activity deleted successfully']);
    }

    public function show($id)
    {
        $activity = TourActivity::with('images')->findOrFail($id);
        return response()->json($activity);
    }

    public function deleteImage($id)
    {
        $image = TourActivityImage::findOrFail($id);
        Storage::disk('public')->delete($image->image);
        $image->delete();

        return response()->json(['success' => true, 'message' => 'Image deleted successfully']);
    }
}
