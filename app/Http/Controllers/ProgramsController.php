<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProgramsController extends Controller
{
    public function index()
    {
        $programs = Program::latest()->get()->map(function ($post) {
            $post->problem = $this->limitText(strip_tags($post->problem), 100);
            $post->solution = $this->limitText(strip_tags($post->solution), 100);
            return $post;
        });
    
        return view('admin.programs', [
            'programs' => $programs,
        ]);
    }
    
    private function limitText($text, $limit = 100) {
        if (strlen($text) <= $limit) {
            return $text;
        }
        return substr($text, 0, $limit) . '...';
    }
    
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    
        $validate = Validator::make($request->all(), $rules);
    
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }
    
        $slug = Str::of($request->input('title'))->slug();
    
        $program = new Program();
        $program->title = $request->input('title');
        $program->description = $request->input('description');
        $program->slug = $slug;
        $program->user_id = Auth()->user()->id;
    
        $dir = 'public/images/programs/';
        if ($request->hasFile('image')) {
            $fileName = $request->file('image')->store($dir);
            $program->image = str_replace($dir, '', $fileName);
        }

    
        try {
            $program->save();
            return redirect()->route('getPrograms')->with('success', 'Program created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create program. Please try again.')->withInput();
        }
    }
    


    public function edit(string $id)
    {
        $program = Program::find($id);
        return view('admin.programUpdate',[
            'program'=>$program,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $post = Program::findOrFail($id);
    
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('public/images/programs');
            $fileName = basename($path);
    
            Storage::delete('public/images/programs/' . $post->image);
    
            $post->image = $fileName;
        }
    
        $post->title = $request->input('title');
        $post->description = $request->input('description');
    
        if ($post->isDirty('title')) {
            $slug = Str::of($request->input('title'))->slug();
    
            $existingPost = Program::where('slug', $slug)->where('id', '!=', $post->id)->first();
            if ($existingPost) {
                $slug .= '-' . uniqid();
            }
            $post->slug = $slug;
        }
    
        $status = $request->input('status');
        if ($status && $status !== $post->status) {
            $post->status = $status;
        }
    
        $post->save();
    
        return redirect()->route('getPrograms')->with('success', 'Event has been updated successfully');
    }
    


    public function destroy($id)
    {
        $program = Program::findOrFail($id);

        if (!$program) {
            return back()->with('error', 'Content not found');
        }
        if ($program->image) {
            Storage::delete('public/images/programs/' . $program->image);
        }
        $program->delete($id);
        return back()
            ->with('success', 'Program deleted successfully');
    
    }
}
