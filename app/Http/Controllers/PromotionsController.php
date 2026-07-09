<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class PromotionsController extends Controller
{
    public function index()
    {
    
        $promotion = Promotion::latest()->get();
    
        return view('admin.tours.promotion', [
            'promotions' => $promotion,
        ]);
    }
    


    public function store(Request $request): RedirectResponse
    {
        $fileName = '';
        if($request->hasFile('image')){
            $file = $request->file('image');
            $path = $file->store('public/images/promotions');
            $fileName = basename($path);
        }
    
        $slug = Str::of($request->input('title'))->slug();
    
        $blog = new Promotion();
        $blog->title = $request->input('title');
        $blog->description = $request->input('description');
        $blog->image = $fileName;
        $blog->slug = $slug;
        $blog->user_id = $request->user()->id;
        $blog->save();
    
        return redirect()->route('getPromotions')->with('success', 'New Promotion has been saved successfully');
    }

    
    public function edit($id)
    {
        $promotion = Promotion::find($id);
        return view('admin.tours.promotionUpdate', [
            'promotion'=>$promotion,
        ]);
    }
    public function view($id)
    {
        $promotion = Promotion::find($id);
        $program= Promotion::all();
        return view('admin.posts.blogView', [
            'service'=>$promotion,
            'program'=>$program,
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $promotion = Promotion::findOrFail($id);
    
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $path = $file->store('public/images/promotions');
                Storage::delete('public/images/promotions/' . $promotion->image);
                $promotion->image = basename($path);
            }
    
            $fields = ['title', 'description', 'status'];
            foreach ($fields as $field) {
                if ($request->has($field) && $request->input($field) !== $promotion->$field) {
                    $promotion->$field = $request->input($field);
                }
            }
    
            if ($promotion->isDirty('title')) {
                $slug = Str::of($promotion->title)->slug();
                if (Promotion::where('slug', $slug)->where('id', '!=', $promotion->id)->exists()) {
                    $slug .= '-' . uniqid();
                }
                $promotion->slug = $slug;
            }
    
            $promotion->save();
    
            return redirect()->route('getPromotions')->with('success', 'Promotion has been updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
    


    public function destroy($id)
    {
        $promotion = Promotion::find($id); 
        if (!$promotion) {
            return back()->with('error', 'Content not found');
        }
        if ($promotion->image) {
            Storage::delete('public/images/promotions/' . $promotion->image);
        }
        $promotion->delete($id);
        return back()
            ->with('success', 'Tour deleted successfully');
    }
}
