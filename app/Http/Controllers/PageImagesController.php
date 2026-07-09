<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Setting;
use App\Models\PageImage;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PageImagesController extends Controller
{
        // Programs Gallery Images

        public function index($pid)
        {
            $page = Page::find($pid);
            $setting = Setting::first();
            $pageImages = DB::table('page_images')->where('page_id', $pid)->get();
            return view('admin.products.images.pageImages', [
                'page' => $page, 'pageImages' => $pageImages,'setting'=>$setting]);
        }
    
        public function store(Request $request, $pid)
        {
            $data = new PageImage();
            $data->page_id = $pid;
            $data->added_by = Auth()->user()->id;
            $data->caption = $request->caption;
    
            // Uploading image
            if ($request->hasFile('image')) {
                $dir = 'public/images/pages';
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
    
        public function destroyProgImage($id)
        {
            $image = PageImage::findOrFail($id);
    
            // Delete the image file
            Storage::delete('public/images/pages/' . $image->image);
    
            // Delete the event
            $image->delete();
    
            return redirect()->back()->with('success', 'Image has been deleted');
    
    
        }
}
