<?php

namespace App\Http\Controllers;

use App\Models\Attraction;
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
            'image' => 'nullable|image|max:4096',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('attractions', 'public');
        } else {
            unset($data['image']);
        }

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
            'image' => 'nullable|image|max:4096',
        ]);

        $attraction = Attraction::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($attraction->image) {
                Storage::disk('public')->delete($attraction->image);
            }
            $data['image'] = $request->file('image')->store('attractions', 'public');
        } else {
            unset($data['image']);
        }

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
