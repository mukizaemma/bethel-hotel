<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Event;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Articlecomment;
use Illuminate\Support\Facades\Mail;
use App\Mail\PublicationNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class EventsController extends Controller
{
    public function index()
    {

        $events = Event::latest()->paginate(10);
        return view('admin.events.events', [
            'events' => $events,
        ]);
    }


        public function store(Request $request): RedirectResponse
        {
    
            $fileName = '';
            if($request->hasFile('image')){
                $file = $request->file('image');
    
                $path = $file->store('public/images/events');
                $fileName = basename($path);
            }
    
            // Generate the slug
            $slug = Str::of($request->input('title'))->slug();
    
            // Check if a blog post with the same slug already exists
            $blog = Event::firstOrCreate(
                ['slug' => $slug],
                [
                    'title' => $request->input('title'),
                    'description' => $request->input('description'),
                    'date' => $request->input('date'),
                    'venue' => $request->input('venue'),
                    'time' => $request->input('time'),
                    'fees' => $request->input('fees'),
                    'image' => $fileName,
                    'slug' => $slug,
                    'user_id' => $request->user()->id,
                ]
            );
            return redirect()->route('getEvents')->with('success', 'New Event has been Saved successfuly');
    }

    
    public function edit($id)
    {
        $post = Event::find($id);
        return view('admin.events.eventUpdate', [
            'post'=>$post,
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $post = Event::findOrFail($id);
    
            // Update image if a new one is uploaded
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $path = $file->store('public/images/events');
                $fileName = basename($path);
    
                // Delete the old image file 
                Storage::delete('public/images/events/' . $post->image);
    
                $post->image = $fileName;
            }
    
            // Update other fields
            $post->title = $request->input('title');
            $post->date = $request->input('date');
            $post->time = $request->input('time');
            $post->venue = $request->input('venue');
            $post->fees = $request->input('fees');
            $post->description = $request->input('description');
    
            // Update the slug if the title has changed
            if ($post->isDirty('title')) {
                $slug = Str::of($request->input('title'))->slug();
                // Check if a blog post with the same slug already exists
                $existingPost = Event::where('slug', $slug)->where('id', '!=', $post->id)->first();
                if ($existingPost) {
                    $slug .= '-' . uniqid();
                }
                $post->slug = $slug;
            }

            // Update the status if changed
            $status = $request->input('status');
            if ($status && $status !== $post->status) {
                $post->status = $status;
            }
    
            $post->save();
    
            return redirect()->route('getEvents')->with('success', 'Event has been updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function publishEvent(Request $request, $id){
        $post = Event::findOrFail($id);
        if($post->status !=='Published'){
            $post->status='Published';
            $post->save();

            $users = User::all();

            foreach($users as $user){
                $details = [
                    'greeting' => 'Hello ' . $user->name . '!',
                    'body' => 'Kwizera Samuel has shared a new event: ' . $post->title,
                    'text' => '' . $post->body,
                    'actiontext' => 'View Article',
                    'actionurl' => route('getBlogs', $post->id), // Adjust the route name as needed
                    'lastline' => 'Thank you!',
                ];
                Mail::to($user->email)->queue(new PublicationNotification($details));
            }
        }
        return redirect()->route('getEvents')->with('success', 'Event has been updated successfully');
    }

    public function destroy($id)
    {
        $blogs = Event::find($id); 
        if (!$blogs) {
            return back()->with('error', 'Content not found');
        }
        if ($blogs->image) {
            Storage::delete('public/images/events/' . $blogs->image);
        }
        $blogs->delete($id);
        return back()
            ->with('success', 'Article deleted successfully');
    }


    public function comments(){
        $comments = Articlecomment::latest()->get();
        return view('admin.posts.comments',[
            'comments'=>$comments,
        ]);
    }
}
