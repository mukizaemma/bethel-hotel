<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Tour;
use App\Models\Tourimage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ToursController extends Controller
{
    public function index()
    {
    
        $tours = Tour::latest()->get();


        $setting = Setting::first();
    
        return view('admin.tours.index', [
            'tours' => $tours,
            'setting' => $setting,
        ]);
    }
    


    public function store(Request $request): RedirectResponse
    {
        $fileName = '';
        if($request->hasFile('image')){
            $file = $request->file('image');
            $path = $file->store('public/images/tours');
            $fileName = basename($path);
        }
    
        $slug = Str::of($request->input('title'))->slug();
    
        $blog = new Tour();
        $blog->title = $request->input('title');
        $blog->description = $request->input('description');
        $blog->image = $fileName;
        $blog->slug = $slug;
        $blog->user_id = $request->user()->id;
        $blog->save();
    
        return redirect()->route('getTours')->with('success', 'New Tour has been saved successfully');
    }

    
    public function edit($id)
    {
        $tour = Tour::findOrFail($id);
        $images = $tour->images;
        $totalImages = $images->count();
        return view('admin.tours.tourUpdate', [
            'tour'=>$tour,
            'images'=>$images,
            'totalImages'=>$totalImages,
        ]);
    }
    public function view($id)
    {
        $service = Tour::find($id);
        $program= Tour::all();
        return view('admin.posts.blogView', [
            'service'=>$service,
            'program'=>$program,
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $post = Tour::findOrFail($id);
    
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $path = $file->store('public/images/tours');
                Storage::delete('public/images/tours/' . $post->image);
                $post->image = basename($path);
            }
    
            $fields = ['title', 'description', 'status'];
            foreach ($fields as $field) {
                if ($request->has($field) && $request->input($field) !== $post->$field) {
                    $post->$field = $request->input($field);
                }
            }
    
            if ($post->isDirty('title')) {
                $slug = Str::of($post->title)->slug();
                if (Tour::where('slug', $slug)->where('id', '!=', $post->id)->exists()) {
                    $slug .= '-' . uniqid();
                }
                $post->slug = $slug;
            }
    
            $post->save();
    
            return redirect()->route('getTours')->with('success', 'Tour has been updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
    


    public function destroy($id)
    {
        $service = Tour::find($id); 
        if (!$service) {
            return back()->with('error', 'Content not found');
        }
        if ($service->image) {
            Storage::delete('public/images/tours/' . $service->image);
        }
        $service->delete($id);
        return back()
            ->with('success', 'Tour deleted successfully');
    }

    public function addTourImage(Request $request)
        {
            $request->validate([
                'image.*'           => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
                'tour_id' => 'required|exists:tours,id',
            ]);

            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $image) {
                    $dir = 'public/images/tours';
                    $path = $image->store($dir);
                    $fileName = str_replace($dir . '/', '', $path);

                    Tourimage::create([
                        'image'             => $fileName,
                        'tour_id' => $request->tour_id, 
                        'user_id' => $request->user()->id
                    ]);
                }

                return redirect()->back()->with('success', 'Images uploaded successfully!');
            }

            return redirect()->back()->with('error', 'No images were uploaded.');
        }

    public function deleteTourImage($id){
        $image = Tourimage::findOrFail($id);

        $imagePath = 'public/images/tours/' . $image->filename;

        if (Storage::exists($imagePath)) {
            Storage::delete($imagePath);
        }

        $image->delete();

        return redirect()->back()->with('warning', 'Image has been deleted');
    }
}
