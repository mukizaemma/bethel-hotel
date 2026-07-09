<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Amenity;
use Illuminate\Support\Str;

class AmenityController extends Controller
{
    public function index()
    {
        $amenities = Amenity::latest()->get();
        return view('content-management.amenities.index', compact('amenities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:amenities,title',
            'icon' => 'nullable|string|max:255',
        ]);

        Amenity::create([
            'title' => $request->title,
            'icon' => $request->icon ?? 'fa-check',
        ]);

        return response()->json(['success' => true, 'message' => 'Amenity created successfully']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:amenities,title,' . $id,
            'icon' => 'nullable|string|max:255',
        ]);

        $amenity = Amenity::findOrFail($id);
        $amenity->update([
            'title' => $request->title,
            'icon' => $request->icon ?? $amenity->icon,
        ]);

        return response()->json(['success' => true, 'message' => 'Amenity updated successfully']);
    }

    public function destroy($id)
    {
        $amenity = Amenity::findOrFail($id);
        $amenity->delete();

        return response()->json(['success' => true, 'message' => 'Amenity deleted successfully']);
    }

    public function show($id)
    {
        $amenity = Amenity::findOrFail($id);
        return response()->json($amenity);
    }
}
