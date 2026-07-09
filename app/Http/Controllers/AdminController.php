<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Setting;
use App\Models\Subscriber;
use App\Models\Room;
use Illuminate\Http\Request;
use App\Models\Articlecomment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\CommentApprovalNotification;
use App\Mail\ContactMessageReplyMail;
use App\Models\BlogComment;
use App\Models\Booking;
use App\Models\Message;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();

        $blogCommets = BlogComment::latest()->get();
        $blogCommetsCount = $blogCommets->count();
        $data = Setting::first();
        $rooms = Room::count();
        $bookings = Booking::latest()->get();
        $today = Carbon::today();
        $weekStart = Carbon::now()->startOfWeek();
        $monthStart = Carbon::now()->startOfMonth();

        $totalVisits = DB::table('visits')->count();
        $todayVisits = DB::table('visits')->whereDate('visited_at', $today)->count();
        $weekVisits = DB::table('visits')->where('visited_at', '>=', $weekStart)->count();
        $monthVisits = DB::table('visits')->where('visited_at', '>=', $monthStart)->count();
        $todayUniqueVisitors = DB::table('visits')
            ->whereDate('visited_at', $today)
            ->selectRaw("COUNT(DISTINCT COALESCE(NULLIF(session_id, ''), ip_address)) as aggregate")
            ->value('aggregate') ?? 0;

        $topVisitedPages = DB::table('visits')
            ->select('path', DB::raw('COUNT(*) as visits'))
            ->where('visited_at', '>=', Carbon::now()->subDays(30))
            ->whereNotNull('path')
            ->groupBy('path')
            ->orderByDesc('visits')
            ->limit(8)
            ->get();

        $topVisitorCountries = DB::table('visits')
            ->select('country_code', DB::raw('COUNT(*) as visits'))
            ->where('visited_at', '>=', Carbon::now()->subDays(30))
            ->whereNotNull('country_code')
            ->where('country_code', '!=', '')
            ->groupBy('country_code')
            ->orderByDesc('visits')
            ->limit(6)
            ->get();

        return view('admin.dashboard',[
            'blogCommetsCount' =>$blogCommetsCount,
            'users'=>$users,
            'data'=>$data,
            'rooms'=>$rooms,
            'bookings'=>$bookings,
            'totalVisits' => $totalVisits,
            'todayVisits' => $todayVisits,
            'weekVisits' => $weekVisits,
            'monthVisits' => $monthVisits,
            'todayUniqueVisitors' => $todayUniqueVisitors,
            'topVisitedPages' => $topVisitedPages,
            'topVisitorCountries' => $topVisitorCountries,
        ]);
    }

    public function users(){
        $users = User::all();
        $setting = Setting::first();
        return view('admin.users',[
            'users'=>$users,
            'setting'=>$setting
        ]);
    }

    public function makeAdmin($id){
        $user = User::find($id);
        $user->role = 1;
        $user->save();

        return redirect()->back()->with('success','User is now an admin');
    }

    
    public function deleteUser($id)
    {
        $post = User::findOrFail($id);
        $post->delete();

        return redirect()->back()->with('success', 'User has been deleted');

    
    }


    public function blogsComment(Request $request)
    {
        $filter = $request->input('filter', 'all'); // Get the filter type, default to 'all'
    
        $comments = BlogComment::query();
    
        if ($filter === 'published') {
            $comments->where('status', 'Published');
        } elseif ($filter === 'unpublished') {
            $comments->where('status', 'Unpublished');
        }
    
        $comments = $comments->latest()->paginate(2);
    
        return view('admin.posts.comments', [
            'comments' => $comments,
            'filter' => $filter, // Pass the current filter to the view
        ]);
    }
    

    public function commentApprove(BlogComment $comment){

        if($comment->status !=='Published'){
            $comment->status='Published';
            $comment->save();

            $user = $comment->user;

            if($user){
                $details = [
                    'greeting' => 'Hello ' . $user->name . '!',
                    'body' => 'Thank you so much for your helpful comment',
                    'lastline' => 'Blessings!',
                ];
                Mail::to($user->email)->queue(new CommentApprovalNotification($details));
                return redirect()->route('blogsComment')->with('success', 'Comment approved successfully');
            }
        }
        return redirect()->back()->with('error', 'Unable to approve comment');

    }

    public function destroyBlogComment($id)
    {
        $comment = BlogComment::find($id); 
        $comment->delete($id);
        return back()
            ->with('success', 'Comment deleted successfully');
    }

    public function subscribers(){
        $setting = Setting::first();
        return view('admin.posts.subscribers',[

            'setting'=>$setting,
        ]);
    }

    
    public function destroySub($id)
    {
        $subscriber = Subscriber::find($id); 
        $subscriber->delete($id);
        return back()
            ->with('success', 'Subscriber deleted successfully');
    }

    public function destroyBooking($id)
    {
        $booking = Booking::find($id); 
        $booking->delete();
        return back()
            ->with('success', 'Booking deleted successfully');
    }

    public function replyBooking(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:confirmed,cancelled',
            'admin_reply' => 'required|string|max:2000',
        ]);
        $booking = Booking::with(['room', 'facility', 'tourActivity'])->findOrFail($id);
        $booking->status = $request->status;
        $booking->admin_reply = $request->admin_reply;
        $booking->admin_replied_at = now();
        $booking->save();

        $guestEmail = $booking->email;
        if ($guestEmail) {
            $itemName = 'Room';
            if ($booking->reservation_type === 'facility' && $booking->facility) {
                $itemName = $booking->facility->title;
            } elseif ($booking->reservation_type === 'tour_activity' && $booking->tourActivity) {
                $itemName = $booking->tourActivity->title;
            } elseif ($booking->room) {
                $itemName = $booking->room->title;
            }
            $statusLabel = $request->status === 'confirmed' ? 'Confirmed' : 'Cancelled';
            $subject = 'Reservation ' . $statusLabel . ' - ' . $itemName;
            $body = "Hello " . $booking->names . ",\n\n";
            $body .= "Your reservation for " . $itemName . " has been " . strtolower($statusLabel) . ".\n\n";
            $body .= "Message from the hotel:\n" . $request->admin_reply . "\n\n";
            $body .= "Check-in: " . ($booking->checkin_date ? $booking->checkin_date->format('Y-m-d') : '') . "\n";
            $body .= "Check-out: " . ($booking->checkout_date ? $booking->checkout_date->format('Y-m-d') : '') . "\n\n";
            $body .= "Thank you.";
            try {
                Mail::raw($body, function ($message) use ($guestEmail, $subject) {
                    $message->to($guestEmail)->subject($subject);
                });
            } catch (\Exception $e) {
                return back()->with('error', 'Reply saved but email could not be sent: ' . $e->getMessage());
            }
        }
        return back()->with('success', 'Reply sent and guest notified by email.');
    }

    public function getMessages()
    {
        $messages = Message::with('room')->latest()->paginate(10);

        return view('admin.posts.messages', [
            'messages' => $messages,
        ]);
    }

    public function replyMessage(Request $request, $id)
    {
        $request->validate([
            'reply_subject' => 'nullable|string|max:255',
            'admin_reply' => 'required|string|max:5000',
        ]);

        $message = Message::findOrFail($id);
        $replySubject = trim((string) $request->input('reply_subject', ''));
        $message->reply_subject = $replySubject !== '' ? $replySubject : null;
        $message->admin_reply = $request->input('admin_reply');
        $message->replied_at = now();
        $message->save();

        if (filled($message->email)) {
            try {
                Mail::to($message->email)->send(new ContactMessageReplyMail($message));

                return back()->with('success', 'Reply sent to the guest by email.');
            } catch (\Throwable $e) {
                Log::error('Contact message reply email failed', ['exception' => $e]);

                return back()->with('error', 'Reply saved but email could not be sent: '.$e->getMessage());
            }
        }

        return back()->with('success', 'Reply saved. No guest email on file — nothing was sent.');
    }

    public function deleteMessages($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();

        return back()
            ->with('success', 'Message deleted successfully');
    }

    // public function visits()
    // {
    //     $totalVisits = DB::table('visits')->count();
    //     $uniqueVisitors = DB::table('visits')->distinct('ip_address')->count();


    //     return view('admin.dashboard',[
    //         'totalVisits'=>$totalVisits,
    //         'uniqueVisitors'=>$uniqueVisitors,
    //     ]);
    // }

}
