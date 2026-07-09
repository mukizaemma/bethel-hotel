<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StaffMember;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TeamsController extends Controller
{
    public function index()
    {
        $team = StaffMember::latest()->get();
        return view('admin.team',['team'=>$team]);
    }

    public function store(Request $request)
    {

        $fileName = '';
        if($request->hasFile('image')){
            $file = $request->file('image');

            $path = $file->store('public/images/team');
            $fileName = basename($path);
        }

        $slug = Str::of($request->input('names'))->slug();

        $blog = StaffMember::firstOrCreate(
            ['slug' => $slug],
            [
                'names' => $request->input('names'),
                'position' => $request->input('position'),
                'description' => $request->input('description'),
                'facebook' => $request->input('facebook'),
                'twitter' => $request->input('twitter'),
                'linkedin' => $request->input('linkedin'),
                'image' => $fileName,
                'slug' => $slug
            ]
        );
        return redirect()->route('staff')->with('success', 'New Team has been added successfuly');
    }


    public function edit($id)
    {
        $team = StaffMember::find($id);
        return view('admin.teamUpdate',['team'=>$team]);
    }

    public function update(Request $request, $id)
    {
        $post = StaffMember::findOrFail($id);
        if($request->hasFile('image')){
            $file = $request->file('image');

            $path = $file->store('public/images/team');
            $fileName = basename($path);
            Storage::delete('public/images/team/' . $post->image);

            $post->image = $fileName;
        }

        $post->names = $request->input('names');
        $post->position = $request->input('position');
        $post->description = $request->input('description');
        $post->facebook = $request->input('facebook');
        $post->twitter = $request->input('twitter');
        $post->linkedin = $request->input('linkedin');
        // $post->display = $request->input('display');

        if($post->names !== $request->input('names')){
            $slug = Str::of($request->input('names'))->slug();
            $existingpost = StaffMember::where('slug', $slug)->first();
            if($existingpost && $existingpost->id !== $post->id){
                $suffix = 1;
                do{
                    $newSlug = $slug . '-' . $suffix++;
                    $existingpost = StaffMember::where('slug', $newSlug)->first();
                }while($existingpost);
                $slug = $newSlug;
            }
            $post->slug = $slug;
        }

        $post->save();

        return redirect()->route('staff')->with('success', 'Team has been updated successfully');
    }


    public function destroy($id)
    {
        $post = StaffMember::findOrFail($id);

        Storage::delete('public/images/team/' . $post->image);

        $post->delete();

        return redirect()->route('staff')->with('success', 'Team has been removed');


    }
}
