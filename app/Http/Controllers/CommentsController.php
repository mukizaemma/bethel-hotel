<?php

namespace App\Http\Controllers;

use App\Mail\BlogCommentsNotofications;
use App\Models\BlogComment;
use Illuminate\Http\Request;
use App\Models\ProductComment;
use App\Mail\CommentsNotofications;
use Illuminate\Support\Facades\Mail;

class CommentsController extends Controller
{
    public function storeProductComment(Request $request) {
        // Check if the user is logged in (this should already be handled by the form visibility)
        $user = auth()->user();
    
        // Validate the request
        $data = $request->validate([
            'product_id' => 'required',
            'comment' => 'required|max:60', 
        ]);
    
        // Create the comment
        $comment = new ProductComment();
        $comment->product_id = $data['product_id'];
        $comment->comment = $data['comment'];
    
        // Associate the comment with the logged-in user
        $comment->added_by = Auth()->user()->id;
    
        // Other comment fields (e.g., status, publish, etc.)
        $comment->status = 'Pending';
        $comment->publish = 'No';
        $comment->published_at = null;
    
        // Save the comment to the database
        if ($comment->save()) {
            $comment = ProductComment::where('id',$comment->id)->with('createdBy')->first();
            Mail::to('mukizaemma34@gmail.com')->send(new CommentsNotofications($comment));
            return redirect()->back()->with('success', 'Comment added successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to add the comment. Please try again.');
        }
    }

    public function storeBlogComment(Request $request) {
        // Check if the user is logged in (this should already be handled by the form visibility)
        $user = auth()->user();
    
        // Validate the request
        $data = $request->validate([
            'blog_id' => 'required',
            'comment' => 'required|max:60', 
        ]);
    
        // Create the comment
        $comment = new BlogComment();
        $comment->blog_id = $data['blog_id'];
        $comment->comment = $data['comment'];
    
        // Associate the comment with the logged-in user
        $comment->created_by = $user->id;
    
        // Other comment fields (e.g., status, publish, etc.)
        $comment->status = 'Pending';
        $comment->publish = 'No';
        $comment->published_at = null;
    
        // Save the comment to the database
        if ($comment->save()) {
            $comment = BlogComment::where('id',$comment->id)->with('user')->first();
            Mail::to('mukizaemma34@gmail.com')->send(new BlogCommentsNotofications($comment));
            return redirect()->back()->with('success', 'Comment added successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to add the comment. Please try again.');
        }
    }
    
}
