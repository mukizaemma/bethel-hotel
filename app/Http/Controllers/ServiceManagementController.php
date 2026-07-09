<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\ServiceImage;
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
            'cover_image' => 'required|image|max:2048',
            'status' => 'required|in:Active,Inactive',
            'images.*' => 'nullable|image|max:2048',
        ]);

        $service = new Service();
        $service->title = $request->title;
        $service->slug = Str::slug($request->title);
        $service->description = $request->description;
        $service->status = $request->status;
        $service->added_by = auth()->id();

        if ($request->hasFile('cover_image')) {
            $service->cover_image = $request->file('cover_image')->store('services', 'public');
        }

        $service->save();

        // Handle gallery images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                ServiceImage::create([
                    'service_id' => $service->id,
                    'image' => $image->store('services/gallery', 'public'),
                    'order' => $index,
                ]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Service created successfully']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'cover_image' => 'nullable|image|max:2048',
            'status' => 'required|in:Active,Inactive',
            'images.*' => 'nullable|image|max:2048',
        ]);

        $service = Service::findOrFail($id);
        $service->title = $request->title;
        $service->slug = Str::slug($request->title);
        $service->description = $request->description;
        $service->status = $request->status;

        if ($request->hasFile('cover_image')) {
            if ($service->cover_image) {
                Storage::disk('public')->delete($service->cover_image);
            }
            $service->cover_image = $request->file('cover_image')->store('services', 'public');
        }

        $service->save();

        // Handle new gallery images
        if ($request->hasFile('images')) {
            $maxOrder = $service->images()->max('order') ?? 0;
            foreach ($request->file('images') as $index => $image) {
                ServiceImage::create([
                    'service_id' => $service->id,
                    'image' => $image->store('services/gallery', 'public'),
                    'order' => $maxOrder + $index + 1,
                ]);
            }
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
