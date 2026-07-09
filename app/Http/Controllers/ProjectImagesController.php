<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Projectimage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProjectImagesController extends Controller
{
    public function projectImage($pid)
    {
        $project = Project::find($pid);
        $images = DB::table('projectimages')->where('project_id', $pid)->get();
        return view('admin.images.projectsGallery', ['project' => $project, 'images' => $images]);
    }

    public function savProjectImage(Request $request, $pid)
    {
        $data = new Projectimage();
        $data->project_id = $pid;
        $data->user_id = Auth()->user()->id;

        // Uploading image
        if ($request->hasFile('image')) {
            $dir = 'public/images/projects';
            $path = $request->file('image')->store($dir);
            $fileName = str_replace($dir, '', $path);
            $data->image = $fileName;
        }

        $stored = $data->save();

        if($stored){
            return redirect()->back()->with('success', 'Image has been saved successfuly');
        }

        return redirect()->back()->with('error','Failed to add new Image');
    }

    public function destroyProjectImage($id)
    {
        $image = Projectimage::findOrFail($id);

        // Delete the image file
        Storage::delete('public/images/projects/' . $image->image);

        // Delete the event
        $image->delete();

        return redirect()->back()->with('success', 'Image has been deleted');


    }
}
