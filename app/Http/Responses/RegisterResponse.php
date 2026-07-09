<?php

namespace App\Http\Responses;

use App\Providers\RouteServiceProvider;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    public function toResponse($request)
    {
        $user = $request->user();
        if (!$user) {
            return redirect()->route('login');
        }

        return redirect(RouteServiceProvider::getDashboardRoute($user));
    }
}
