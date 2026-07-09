<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function verify($token)
    {
        $user = User::where('verification_token', $token)->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Invalid verification token.');
        }

        if ($user->email_verified_at) {
            return redirect()->route('login')->with('info', 'Email already verified.');
        }

        $user->email_verified_at = now();
        $user->verification_token = null;
        $user->save();

        return redirect()->route('login')->with('success', 'Email verified successfully. You can now login.');
    }

    public function resend(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->email_verified_at) {
            return back()->with('info', 'Email already verified.');
        }

        if (!$user->verification_token) {
            $user->verification_token = \Illuminate\Support\Str::random(60);
            $user->save();
        }

        \Illuminate\Support\Facades\Mail::to($user->email)
            ->send(new \App\Mail\EmailVerificationMail($user));

        return back()->with('success', 'Verification email sent. Please check your inbox.');
    }
}
