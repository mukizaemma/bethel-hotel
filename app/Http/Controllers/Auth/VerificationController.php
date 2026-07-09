<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
        // use VerifiesEmails;

    // Show the email verification notice
    public function show()
    {
        return view('auth.verify');
    }

    // Verify the user's email
    public function verify(Request $request)
    {
        // Your verification logic here
        // Usually involves checking the ID and hash, and marking the email as verified

        return redirect('/home')->with('verified', true);
    }

    // Resend the verification email
    public function resend(Request $request)
    {
        $this->middleware('throttle:6,1'); // Rate limit the requests

        if ($request->user()->hasVerifiedEmail()) {
            return response(['message' => 'Email already verified.'], 400);
        }

        $request->user()->sendEmailVerificationNotification();

        return response(['message' => 'Verification link sent!']);
    }
}
