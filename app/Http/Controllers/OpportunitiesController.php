<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Program;
use App\Models\Setting;
use App\Models\Subscriber;
use App\Models\BlogComment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\PublicationNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class OpportunitiesController extends Controller
{
    public function index()
    {
        function limitText($text, $limit = 100) {
            if (strlen($text) <= $limit) {
                return $text;
            }
            return substr($text, 0, $limit) . '...';
        }
    
        $latestBlogs = Post::with('program')
            ->latest()
            ->get()
            ->map(function ($post) {
                $post->short_body = limitText(strip_tags($post->description), 100);
                return $post;
            });
    
        $mostViewedBlogs = Post::with('program')
            ->orderBy('views', 'desc')
            ->get()
            ->map(function ($post) {
                $post->short_body = limitText(strip_tags($post->body), 100);
                return $post;
            });
    
        $blogCategories = Program::all();
        $setting = Setting::first();
    
        return view('admin.posts.blogs', [
            'blogCategories' => $blogCategories,
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
    
        $blog = new Post();
        $blog->title = $request->input('title');
        $blog->description = $request->input('description');
        $blog->applicationLink = $request->input('applicationLink');
        $blog->image = $fileName;
        $blog->slug = $slug;
        $blog->program_id = $request->input('program_id');
        $blog->added_by = $request->user()->id;
        $blog->save();
    
        return redirect()->route('getPosts')->with('success', 'New Post has been saved successfully');
    }

    
    public function edit($id)
    {
        $post = Post::find($id);
        $program= Program::all();
        return view('admin.posts.blogUpdate', [
            'post'=>$post,
            'program'=>$program
        ]);
    }
    public function view($id)
    {
        $post = Post::find($id);
        $comments = BlogComment::where('blog_id',$post->id)->latest()->get();
        $totalComments = $comments->count();
        $program= Program::all();
        return view('admin.posts.blogView', [
            'post'=>$post,
            'program'=>$program,
            'comments'=>$comments,
            'totalComments'=>$totalComments
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $post = Post::findOrFail($id);
    
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $path = $file->store('public/images/blogs');
                Storage::delete('public/images/blogs/' . $post->image);
                $post->image = basename($path);
            }
    
            $fields = ['title', 'description', 'applicationLink','status'];
            foreach ($fields as $field) {
                if ($request->has($field) && $request->input($field) !== $post->$field) {
                    $post->$field = $request->input($field);
                }
            }
    
            if ($post->isDirty('title')) {
                $slug = Str::of($post->title)->slug();
                if (Post::where('slug', $slug)->where('id', '!=', $post->id)->exists()) {
                    $slug .= '-' . uniqid();
                }
                $post->slug = $slug;
            }
    
            $post->save();
    
            return redirect()->route('getPosts')->with('success', 'Post has been updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
    

    public function publish(Request $request, $id){
        $post = Post::findOrFail($id);
        if($post->status !=='Published'){
            $post->status='Published';
            $post->save();

            $users = Subscriber::all();

            foreach($users as $user){
                $details = [
                    'greeting' => 'Hello ' . $user->name . '!',
                    'body' => 'Isange Paradise has shared a new update: ' . $post->title,
                    'text' => '' . $post->body,
                    'actiontext' => 'View Story',
                    'actionurl' => url('/Updates/' . $post->slug),
                    'lastline' => 'Thank you!',
                ];
                Mail::to($user->email)->queue(new PublicationNotification($details));
            }
        }
        return redirect()->route('getPosts')->with('success', 'Story has been updated successfully');
    }

    public function destroy($id)
    {
        $blogs = Post::find($id); 
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
