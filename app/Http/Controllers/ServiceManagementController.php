<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\ServiceImage;
use App\Services\MediaLibrary;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ServiceManagementController extends Controller
{
    public function index()
    {
        $services = Service::with('images')->latest()->get();
        return view('content-management.services.index', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'cover_image' => 'nullable|image|max:10240',
            'existing_cover_media_id' => 'nullable|integer|exists:media_images,id',
            'status' => 'required|in:Active,Inactive',
            'images.*' => 'nullable|image|max:10240',
            'existing_media_ids' => 'nullable|array',
            'existing_media_ids.*' => 'integer|exists:media_images,id',
        ]);

        $mediaLibrary = app(MediaLibrary::class);
        $cover = $mediaLibrary->pathFromRequest($request, 'cover_image', 'existing_cover_media_id', 'services');
        if (! $cover) {
            return response()->json(['success' => false, 'message' => 'Upload a cover image or select one from the library.'], 422);
        }

        $service = new Service();
        $service->title = $request->title;
        $service->slug = Str::slug($request->title);
        $service->description = $request->description;
        $service->status = $request->status;
        $service->added_by = auth()->id();
        $service->cover_image = $cover;
        $service->save();

        foreach ($mediaLibrary->pathsFromRequest($request, 'images', 'existing_media_ids', 'services/gallery') as $index => $path) {
            ServiceImage::create([
                'service_id' => $service->id,
                'image' => $path,
                'order' => $index,
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Service created successfully']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'cover_image' => 'nullable|image|max:10240',
            'existing_cover_media_id' => 'nullable|integer|exists:media_images,id',
            'status' => 'required|in:Active,Inactive',
            'images.*' => 'nullable|image|max:10240',
            'existing_media_ids' => 'nullable|array',
            'existing_media_ids.*' => 'integer|exists:media_images,id',
        ]);

        $mediaLibrary = app(MediaLibrary::class);
        $service = Service::findOrFail($id);
        $service->title = $request->title;
        $service->slug = Str::slug($request->title);
        $service->description = $request->description;
        $service->status = $request->status;

        $cover = $mediaLibrary->pathFromRequest($request, 'cover_image', 'existing_cover_media_id', 'services');
        if ($cover) {
            $service->cover_image = $cover;
        }

        $service->save();

        $order = (int) ($service->images()->max('order') ?? 0);
        foreach ($mediaLibrary->pathsFromRequest($request, 'images', 'existing_media_ids', 'services/gallery') as $path) {
            $order++;
            ServiceImage::create([
                'service_id' => $service->id,
                'image' => $path,
                'order' => $order,
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Service updated successfully']);
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        
        // Delete cover image
        if ($service->cover_image) {
            Storage::disk('public')->delete($service->cover_image);
        }

        // Delete gallery images
        foreach ($service->images as $image) {
            Storage::disk('public')->delete($image->image);
            $image->delete();
        }

        $service->delete();

        return response()->json(['success' => true, 'message' => 'Service deleted successfully']);
    }

    public function show($id)
    {
        $service = Service::with('images')->findOrFail($id);
        return response()->json($service);
    }

    public function deleteImage($id)
    {
        $image = ServiceImage::findOrFail($id);
        Storage::disk('public')->delete($image->image);
        $image->delete();

        return response()->json(['success' => true, 'message' => 'Image deleted successfully']);
    }
}
