<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\User;
use App\Models\Setting;
use App\Models\Subscriber;
use App\Models\BlogComment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\PublicationNotification;
use Illuminate\Http\RedirectResponse;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class BlogsController extends Controller
{
    private function limitText($text, $limit = 100)
    {
        if (strlen($text) <= $limit) {
            return $text;
        }
        return substr($text, 0, $limit) . '...';
    }
    
    public function index()
    {
        $latestBlogs = Blog::latest()
            ->get()
            ->map(function ($post) {
                $post->short_body = $this->limitText(strip_tags($post->body), 100);
                return $post;
            });
    
        $mostViewedBlogs = Blog::orderBy('views', 'desc')
            ->get()
            ->map(function ($post) {
                $post->short_body = $this->limitText(strip_tags($post->body), 100);
                return $post;
            });
    
        $setting = Setting::first();
    
        return view('admin.posts.blogs', [
            'latestBlogs' => $latestBlogs,
            'mostViewedBlogs' => $mostViewedBlogs,
            'setting' => $setting,
        ]);
    }
    
    


    public function store(Request $request): RedirectResponse
    {
        $fileName = '';
        if($request->hasFile('image')){
            $file = $request->file('image');
            $path = $file->store('public/images/blogs');
            $fileName = basename($path);
        }
    
        $slug = Str::of($request->input('title'))->slug();
    
        $blog = new Blog();
        $blog->title = $request->input('title');
        $blog->body = $request->input('body');
        $blog->image = $fileName;
        $blog->slug = $slug;
        $blog->added_by = $request->user()->id;
        $blog->save();
    
        return redirect()->route('getBlogs')->with('success', 'New Post has been saved successfully');
    }

    
    public function edit($id)
    {
        $blog = Blog::find($id);
        return view('admin.posts.blogUpdate', [
            'blog'=>$blog,
        ]);
    }
    public function view($id)
    {
        $post = Blog::find($id);
        $comments = BlogComment::where('blog_id',$post->id)->latest()->get();
        $totalComments = $comments->count();
        return view('admin.posts.blogView', [
            'post'=>$post,
            'comments'=>$comments,
            'totalComments'=>$totalComments
        ]);
    }

public function update(Request $request, $id)
{
    $post = Blog::findOrFail($id);

    // Check and update image if changed
    if ($request->hasFile('image')) {
        if ($post->image && Storage::exists('public/images/blogs/' . $post->image)) {
            Storage::delete('public/images/blogs/' . $post->image);
        }

        $path = $request->file('image')->store('public/images/blogs');
        $post->image = basename($path);
    }

    // Update only if values changed
    if ($request->filled('title') && $request->input('title') !== $post->title) {
        $post->title = $request->input('title');

        // Update slug only when title changes
        $slug = Str::slug($post->title);
        if (Blog::where('slug', $slug)->where('id', '!=', $post->id)->exists()) {
            $slug .= '-' . uniqid();
        }
        $post->slug = $slug;
    }

    if ($request->filled('body') && $request->input('body') !== $post->body) {
        $post->body = $request->input('body');
    }

    if ($request->filled('status') && $request->input('status') !== $post->status) {
        $post->status = $request->input('status');
    }

    // Save only if any field is dirty
    if ($post->isDirty()) {
        $post->save();
    }

    return redirect()->route('getBlogs')->with('success', 'Story updated successfully');
}

    

    public function publish(Request $request, $id){
        $post = Blog::findOrFail($id);
        if($post->status !=='Published'){
            $post->status='Published';
            $post->save();
        }
        return redirect()->route('getBlogs')->with('success', 'Story has been updated successfully');
    }

    public function destroy($id)
    {
        $blogs = Blog::find($id); 
        if (!$blogs) {
            return back()->with('error', 'Content not found');
        }
        if ($blogs->image) {
            Storage::delete('public/images/blogs/' . $blogs->image);
        }
        $blogs->delete($id);
        return back()
            ->with('success', 'Story deleted successfully');
    }


    public function comments(){
        $comments = BlogComment::latest()->get();
        return view('admin.posts.comments',[
            'comments'=>$comments,
        ]);
    }
}
