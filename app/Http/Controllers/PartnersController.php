<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\File;

class PartnersController extends Controller
{
    public function index()
    {

        $partners = Partner::all();
        $setting = Setting::first();
        return view('admin.partners', [
            'partners' => $partners,
            'setting' => $setting
        ]);
    }


        public function store(Request $request): RedirectResponse
        {
    
            $fileName = '';
            if($request->hasFile('image')){
                $file = $request->file('image');
    
                $path = $file->store('public/images/partners');
                $fileName = basename($path);
            }
    
            // Generate the slug
            $slug = Str::of($request->input('name'))->slug();
    
            // Check if a blog post with the same slug already exists
            $blog = Partner::firstOrCreate(
                ['slug' => $slug],
                [
                    'name' => $request->input('name'),
                    'website' => $request->input('website'),
                    'description' => $request->input('description'),
                    'status' => 'Active',
                    'image' => $fileName,
                    'slug' => $slug,
                ]
            );
            return redirect('getPartners')->with('success', 'New Partner has been Saved successfuly');
    }

    
    public function edit($id)
    {
        $partner = Partner::find($id);
        return view('admin.partnerUpdate', [
            'partner'=>$partner
        ]);
    }


    public function update(Request $request, $id)
    {

        try {
            $partner = Partner::findOrFail($id);
    
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $path = $file->store('public/images/partners');
                Storage::delete('public/images/partners/' . $partner->image);
                $partner->image = basename($path);
            }
    
            $fields = ['name', 'website','description','status'];
            foreach ($fields as $field) {
                if ($request->has($field) && $request->input($field) !== $partner->$field) {
                    $partner->$field = $request->input($field);
                }
            }
    
            if ($partner->isDirty('title')) {
                $slug = Str::of($partner->title)->slug();
                if (Partner::where('slug', $slug)->where('id', '!=', $partner->id)->exists()) {
                    $slug .= '-' . uniqid();
                }
                $partner->slug = $slug;
            }
    
            $partner->save();
    
            return redirect()->route('getPartners')->with('success', 'Partner has been updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }




    public function destroy($id)
    {
        $partner = Partner::find($id); 
        $partner->delete($id);
        return back()
            ->with('success', 'Partner deleted successfully');
    }
}
