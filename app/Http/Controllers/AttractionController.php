<?php

namespace App\Http\Controllers;

use App\Models\Attraction;
use App\Services\MediaLibrary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttractionController extends Controller
{
    public function index()
    {
        $attractions = Attraction::query()->latest()->get();

        return view('content-management.attractions.index', compact('attractions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:10240',
            'existing_media_id' => 'nullable|integer|exists:media_images,id',
        ]);

        $image = app(MediaLibrary::class)->pathFromRequest($request, 'image', 'existing_media_id', 'attractions');
        if ($image) {
            $data['image'] = $image;
        } else {
            unset($data['image']);
        }
        unset($data['existing_media_id']);

        Attraction::create($data);

        return response()->json(['success' => true, 'message' => 'Attraction created successfully']);
    }

    public function show($id)
    {
        $attraction = Attraction::findOrFail($id);

        return response()->json($attraction);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:10240',
            'existing_media_id' => 'nullable|integer|exists:media_images,id',
        ]);

        $attraction = Attraction::findOrFail($id);

        $image = app(MediaLibrary::class)->pathFromRequest($request, 'image', 'existing_media_id', 'attractions');
        if ($image) {
            $data['image'] = $image;
        } else {
            unset($data['image']);
        }
        unset($data['existing_media_id']);

        $attraction->update($data);

        return response()->json(['success' => true, 'message' => 'Attraction updated successfully']);
    }

    public function destroy($id)
    {
        $attraction = Attraction::findOrFail($id);
        if ($attraction->image) {
            Storage::disk('public')->delete($attraction->image);
        }
        $attraction->delete();

        return response()->json(['success' => true, 'message' => 'Attraction deleted successfully']);
    }
}
