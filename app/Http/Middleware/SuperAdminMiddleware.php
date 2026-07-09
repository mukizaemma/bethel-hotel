<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        
        // Only allow role_id = 1 (Super Admin)
        if (!auth()->check() || $user->role_id != 1) {
            abort(403, 'Unauthorized access. Super Admin access required.');
        }

        return $next($request);
    }
}
