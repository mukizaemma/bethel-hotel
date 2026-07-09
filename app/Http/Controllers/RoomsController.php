<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\Setting;
use App\Models\Room;
use App\Models\Roomimage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class RoomsController extends Controller
{
    public function index()
    {
    
        $rooms = Room::latest()->get();
        $amenities = Amenity::all();
        $setting = Setting::first();    
        return view('admin.rooms.index', [
            'rooms' => $rooms,
            'setting' => $setting,
            'amenities' => $amenities,
        ]);
    }
    


    public function store(Request $request): RedirectResponse
    {
        $fileName = '';
        if($request->hasFile('image')){
            $file = $request->file('image');
            $path = $file->store('public/images/rooms');
            $fileName = basename($path);
        }
    
        $slug = Str::of($request->input('title'))->slug();
    
        $room = new Room();
        $room->title = $request->input('title');
        $room->description = $request->input('description');
        $room->category = 'Rooms';
        $room->room_type = 'room';
        $room->price = $request->input('price');
        $room->image = $fileName;
        $room->slug = $slug;
        $room->user_id = $request->user()->id;
        $room->save();

        if ($request->has('amenities')) {
        $room->amenities()->sync($request->input('amenities'));
    }
    
        return redirect()->route('getRooms')->with('success', 'New Room has been saved successfully');
    }

    
    public function edit($id)
    {
        $room = Room::with('amenities')->findOrFail($id);
        $images = $room->images;
        $totalImages = $images->count();
        $allAmenities = Amenity::all();
        $setting = Setting::first();

        return view('admin.rooms.roomUpdate', [
            'room' => $room,
            'allAmenities' => $allAmenities,
            'images' => $images,
            'totalImages' => $totalImages,
            'setting' => $setting,
        ]);
    }
    public function view($id)
    {
        $room = Room::find($id);
        $program= Room::all();
        return view('admin.posts.blogView', [
            'service'=>$room,
            'program'=>$program,
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $room = Room::findOrFail($id);
    
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $path = $file->store('public/images/rooms');
                Storage::delete('public/images/rooms/' . $room->image);
                $room->image = basename($path);
            }
    
            $fields = ['title', 'price', 'description', 'status'];
            foreach ($fields as $field) {
                if ($request->has($field) && $request->input($field) !== $room->$field) {
                    $room->$field = $request->input($field);
                }
            }
            $room->category = 'Rooms';
            $room->room_type = 'room';
    
            if ($room->isDirty('title')) {
                $slug = Str::of($room->title)->slug();
                if (Room::where('slug', $slug)->where('id', '!=', $room->id)->exists()) {
                    $slug .= '-' . uniqid();
                }
                $room->slug = $slug;
            }
    
            $room->save();

            if ($request->has('amenities')) {
            $room->amenities()->sync($request->input('amenities'));
            } else {

                $room->amenities()->sync([]);
            }
    
            return redirect()->route('getRooms')->with('success', 'Service has been updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
    


    public function destroy($id)
    {
        $room = Room::find($id); 
        if (!$room) {
            return back()->with('error', 'Content not found');
        }
        if ($room->image) {
            Storage::delete('public/images/rooms/' . $room->image);
        }
        $room->delete($id);
        return back()
            ->with('success', 'Story deleted successfully');
    }

    
    public function addRoomImage(Request $request)
        {
            $request->validate([
                'image.*'           => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate each image
                'room_id' => 'required|exists:rooms,id', // Ensure the wedding gallery exists
            ]);

            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $image) {
                    $dir = 'public/images/rooms';
                    $path = $image->store($dir);
                    $fileName = str_replace($dir . '/', '', $path);

                    Roomimage::create([
                        'image'             => $fileName,
                        'room_id' => $request->room_id, 
                        'user_id' => $request->user()->id
                    ]);
                }

                return redirect()->back()->with('success', 'Images uploaded successfully!');
            }

            return redirect()->back()->with('error', 'No images were uploaded.');
        }

    public function deleteRoomImage($id){
        $image = Roomimage::findOrFail($id);

        $imagePath = 'public/images/rooms/' . $image->filename;

        if (Storage::exists($imagePath)) {
            Storage::delete($imagePath);
        }

        $image->delete();

        return redirect()->back()->with('warning', 'Image has been deleted');
    }

}
