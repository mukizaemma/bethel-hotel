<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ImagesController extends Controller
{
    public function index()
    {

        $images = Image::latest()->get();
        $setting = Setting::first();
        return view('admin.includes.gallery', ['images'=>$images,'setting'=>$setting]);
    }


    public function store(Request $request)
    {
        $data = new Image();
        $data ->caption = $request->caption;
        $data ->category = $request->category;

        // Uploading image
        if ($request->hasFile('image')) {
            $dir = 'public/images/gallery';
            $path = $request->file('image')->store($dir);
            $fileName = str_replace($dir, '', $path);
            $data->image = $fileName;
        }

        $stored = $data->save();

        if($stored){
            return redirect('images')->with('success', 'New Image has been added successfuly');
        }

        return redirect()->back()->with('error','Failed to add new Image');
    }

    public function edit($id)
    {
        $data = Image::find($id);
        return view('admin.includes.slideUpdate', ['data'=>$data]);
    }

    public function update(Request $request, $id)
    {
        $data = Image::find($id);
        $data->caption = $request->input('caption');
        $data->category = $request->input('category');

        if(!$data){
            return back()->with('Error','Image Not Found');
        }

        if ($request->hasFile('image') && request('image') != '') {
            $dir = 'public/images/gallery';

            if (File::exists($dir)) {
                unlink($dir);
            }
            $path = $request->file('image')->store($dir);
            $fileName = str_replace($dir, '', $path);

            $data->image = $fileName;
        }

        $updated = $data->update();

        if($updated){
            return redirect('images')->with('success','Image has been updated');
        }
        else{
            return redirect('images')->with('error','SOmething went wrong');
        }
    }

    public function destroy($id)
    {
        $image = Image::findOrFail($id);
        // delete the image file
        Storage::delete('public/images/gallery/'.$image);
        $image->delete();
        return redirect()->back()->with('warning', 'Item has been deleted');
    }
}
