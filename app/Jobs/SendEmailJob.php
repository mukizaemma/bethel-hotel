<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use App\Mail\PublicationNotification;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $details;
    public function __construct(User $user, array $details)
    {
        $this->user = $user;
        $this->details = $details;
    }
    public function handle(): void
    {
        $emailDetails = [
            'greeting' => 'Hello ' . $this->user->name . '!',
            'body' => 'Kwizera Samuel has shared a new article: ' . $this->details['title'],
            'text' => '' . $this->details['body'],
            'actiontext' => 'View Article',
            'actionurl' => route('getBlogs', $this->details['blog_id']), // Adjust the route name as needed
            'lastline' => 'Thank you!',
        ];
        Mail::to($this->user->email)->send(new PublicationNotification($this->details));
    }
    
}
