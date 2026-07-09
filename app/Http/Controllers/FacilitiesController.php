<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Facility;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Facilityimage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class FacilitiesController extends Controller
{
    public function index()
    {
    
        $facilities = Facility::latest()->get();


        $setting = Setting::first();
    
        return view('admin.facilities.index', [
            'facilities' => $facilities,
            'setting' => $setting,
        ]);
    }
    


    public function store(Request $request): RedirectResponse
    {
        $fileName = '';
        if($request->hasFile('image')){
            $file = $request->file('image');
            $path = $file->store('public/images/facilities');
            $fileName = basename($path);
        }
    
        $slug = Str::of($request->input('title'))->slug();
    
        $blog = new Facility();
        $blog->title = $request->input('title');
        $blog->description = $request->input('description');
        $blog->image = $fileName;
        $blog->slug = $slug;
        $blog->added_by = $request->user()->id;
        $blog->save();
    
        return redirect()->route('getFacilities')->with('success', 'New Facility has been saved successfully');
    }

    
    public function edit($id)
    {
        $facility = Facility::find($id);
        $images = $facility->images ?? collect();
        $totalImages = $images->count();

        return view('admin.facilities.facilityUpdate', [
            'facility'=>$facility,
            'images'=>$images,
            'totalImages'=>$totalImages,
        ]);
    }
    public function view($id)
    {
        $facility = Facility::find($id);
        $program= Facility::all();
        return view('admin.posts.blogView', [
            'service'=>$facility,
            'program'=>$program,
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $facility = Facility::findOrFail($id);
    
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $path = $file->store('public/images/facilities');
                Storage::delete('public/images/facilities/' . $facility->image);
                $facility->image = basename($path);
            }
    
            $fields = ['title', 'description', 'status'];
            foreach ($fields as $field) {
                if ($request->has($field) && $request->input($field) !== $facility->$field) {
                    $facility->$field = $request->input($field);
                }
            }
    
            if ($facility->isDirty('title')) {
                $slug = Str::of($facility->title)->slug();
                if (Facility::where('slug', $slug)->where('id', '!=', $facility->id)->exists()) {
                    $slug .= '-' . uniqid();
                }
                $facility->slug = $slug;
            }
    
            $facility->save();
    
            return redirect()->route('getFacilities')->with('success', 'Service has been updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
    


    public function destroy($id)
    {
        $facility = Facility::find($id); 
        if (!$facility) {
            return back()->with('error', 'Content not found');
        }
        if ($facility->image) {
            Storage::delete('public/images/facilities/' . $facility->image);
        }
        $facility->delete($id);
        return back()
            ->with('success', 'Story deleted successfully');
    }

        
    public function addFacilityImage(Request $request)
        {
            $request->validate([
                'image.*'           => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate each image
                'facility_id' => 'required|exists:facilities,id', // Ensure the wedding gallery exists
            ]);

            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $image) {
                    $dir = 'public/images/facilities';
                    $path = $image->store($dir);
                    $fileName = str_replace($dir . '/', '', $path);

                    Facilityimage::create([
                        'image'             => $fileName,
                        'facility_id' => $request->facility_id, 
                        'added_by' => $request->user()->id
                    ]);
                }

                return redirect()->back()->with('success', 'Images uploaded successfully!');
            }

            return redirect()->back()->with('error', 'No images were uploaded.');
        }

    public function deleteFacilityImage($id){
        $image = Facilityimage::findOrFail($id);

        $imagePath = 'public/images/facilities/' . $image->filename;

        if (Storage::exists($imagePath)) {
            Storage::delete($imagePath);
        }

        $image->delete();

        return redirect()->back()->with('warning', 'Image has been deleted');
    }
}
