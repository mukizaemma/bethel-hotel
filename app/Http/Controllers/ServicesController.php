<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ServicesController extends Controller
{
    public function index()
    {
        function limitText($text, $limit = 100) {
            if (strlen($text) <= $limit) {
                return $text;
            }
            return substr($text, 0, $limit) . '...';
        }
    
        $services = Program::latest()
            ->get()
            ->map(function ($data) {
                $data->short_body = limitText(strip_tags($data->description), 100);
                return $data;
            });


        $setting = Setting::first();
    
        return view('admin.services.index', [
            'services' => $services,
            'setting' => $setting,
        ]);
    }
    


    public function store(Request $request): RedirectResponse
    {
        $fileName = '';
        if($request->hasFile('image')){
            $file = $request->file('image');
            $path = $file->store('public/images/services');
            $fileName = basename($path);
        }
    
        $slug = Str::of($request->input('title'))->slug();
    
        $blog = new Program();
        $blog->title = $request->input('title');
        $blog->description = $request->input('description');
        $blog->image = $fileName;
        $blog->slug = $slug;
        $blog->user_id = $request->user()->id;
        $blog->save();
    
        return redirect()->route('getServices')->with('success', 'New Service has been saved successfully');
    }

    
    public function edit($id)
    {
        $service = Program::find($id);
        return view('admin.services.serviceUpdate', [
            'service'=>$service,
        ]);
    }
    public function view($id)
    {
        $service = Program::find($id);
        $program= Program::all();
        return view('admin.posts.blogView', [
            'service'=>$service,
            'program'=>$program,
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $post = Program::findOrFail($id);
    
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $path = $file->store('public/images/services');
                Storage::delete('public/images/services/' . $post->image);
                $post->image = basename($path);
            }
    
            $fields = ['title', 'body', 'status'];
            foreach ($fields as $field) {
                if ($request->has($field) && $request->input($field) !== $post->$field) {
                    $post->$field = $request->input($field);
                }
            }
    
            if ($post->isDirty('title')) {
                $slug = Str::of($post->title)->slug();
                if (Program::where('slug', $slug)->where('id', '!=', $post->id)->exists()) {
                    $slug .= '-' . uniqid();
                }
                $post->slug = $slug;
            }
    
            $post->save();
    
            return redirect()->route('getServices')->with('success', 'Service has been updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
    


    public function destroy($id)
    {
        $service = Program::find($id); 
        if (!$service) {
            return back()->with('error', 'Content not found');
        }
        if ($service->image) {
            Storage::delete('public/images/services/' . $service->image);
        }
        $service->delete($id);
        return back()
            ->with('success', 'Story deleted successfully');
    }
}
