<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TestimonailsController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::latest()->get();
        return view('admin.testimonials',[
            'testimonials'=>$testimonials,
        ]);
    }

    public function store(Request $request)
    {

        $rules = [
            'title' => 'required',
        ];
      
        $validate = Validator::make($request->all(), $rules);
        if (!$validate) {
            return 'Invalid Data';
        } 

        $slug = Str::of($request->input('title'))->slug();
        $testimonial= new Testimonial();
        $testimonial->title = $request->title;
        $testimonial->names = $request->names;
        $testimonial->testimony = $request->testimony;
        $testimonial->slug = $slug;
        $testimonial->added_by = Auth()->user()->id;

        $dir = 'public/images/testimonials/';
        if ($request->hasFile('image') && request('image') != '') {

            $fileName = $request->file('image')->store($dir);
            $testimonial->image = str_replace($dir, '', $fileName);
            $image[] = 'image';
        }

        $testimonial->save();
        
        return redirect()->route('getTestimonials')->with('success', 'Testimonial created successfully.'); 
        
    }


    public function edit($id)
    {
        $testimonial = Testimonial::find($id);
        return view('admin.testimonialUpdate',[
            'testimonial' => $testimonial,
        ]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'title' => 'required',
        ];
    
        $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }
    
        try {
            $testimonial = Testimonial::findOrFail($id);
            
            // Update fields only if they have changed
            $updated = false;
    
            $slug = Str::of($request->input('title'))->slug();
    
            // Handle image update
            if ($request->hasFile('image')) {
                $dir = 'public/images/testimonials/';
                $fileName = $request->file('image')->store($dir);
    
                // Delete old image if it exists
                if ($testimonial->image && Storage::exists($dir . $testimonial->image)) {
                    Storage::delete($dir . $testimonial->image);
                }
    
                $testimonial->image = str_replace($dir, '', $fileName);
                $updated = true;
            }
    
            // Update other fields
            if ($testimonial->title !== $request->input('title')) {
                $testimonial->title = $request->input('title');
                $updated = true;
            }
    
            if ($testimonial->names !== $request->input('names')) {
                $testimonial->names = $request->input('names');
                $updated = true;
            }
    
            if ($testimonial->testimony !== $request->input('testimony')) {
                $testimonial->testimony = $request->input('testimony');
                $updated = true;
            }
    
            if ($testimonial->slug !== $slug) {
                $testimonial->slug = $slug;
                $updated = true;
            }
    
            // Save only if something was updated
            if ($updated) {
                $testimonial->save();
            }
    
            return redirect()->route('getTestimonials')->with('success', 'Testimonial updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Error updating testimonial: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }
    
    
    public function destroy($id)
    {
        $post = Testimonial::findOrFail($id);

        // Delete the post
        $post->delete();

        return redirect()->route('getTestimonials')->with('success', 'Data has been deleted');

    
    }
}
