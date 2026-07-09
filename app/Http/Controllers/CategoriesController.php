<?php

namespace App\Http\Controllers;

use Ramsey\Uuid\Uuid;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{

    public function index()
    {
        $categories = Category::with('blogs')->get();
        return view('admin.posts.categories',[
            'categories'=>$categories,
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    
        $validate = Validator::make($request->all(), $rules);
        
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        } 
    
        $fileName = '';
        if($request->hasFile('image')){
            $file = $request->file('image');
            $path = $file->store('public/images/blogs');
            $fileName = basename($path);
        }
    
        $slug = Str::of($request->input('name'))->slug();
    
        $category = new Category();
        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $category->slug = $slug;
        $category->image = $fileName;
        $saved = $category->save();
        
        if($saved){
            return redirect()->route('getCategories')->with('success', 'Category created successfully.');
        }
        else{
            return redirect()->back()->with('error', 'Something Went wrong.');
        }
    }
    
    public function edit(string $id)
    {
        $category = Category::find($id);
        return view('admin.posts.categoryUpdate', [
            'category'=>$category,
        ]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    
        $validate = Validator::make($request->all(), $rules);
    
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }
    
        $category = Category::findOrFail($id);
    
        $data = [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'slug' => Str::of($request->input('name'))->slug(),
        ];
    
        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::delete('public/images/blogs/' . $category->image);
            }
    
            $file = $request->file('image');
            $path = $file->store('public/images/blogs');
            $data['image'] = basename($path);
        }
    
        // Update the category and check if the save was successful
        $updated = $category->update($data);
    
        if ($updated) {
            return redirect()->route('getCategories')->with('success', 'Category updated successfully.');
        }
    
        return redirect()->route('getCategories')->with('error', 'Failed to update the category. Please try again.');
    }
    
    
    
    public function destroy($id)
    {
        $post = Category::findOrFail($id);
    
        if ($post->image) {
            $imagePath = public_path('storage/images/blogs/' . $post->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
    
        $post->delete();
    
        return redirect('getPodcastCategories')->with('success', 'Data has been deleted');
    }
    

}
