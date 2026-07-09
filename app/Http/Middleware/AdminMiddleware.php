<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        
        // Allow Super Admin (role_id = 1) and Content Manager (role_id = 2)
        if (!auth()->check() || (!$user->isSuperAdmin() && !$user->isContentManager())) {
            abort(403, 'Unauthorized access. Content Manager or Super Admin access required.');
        }

        return $next($request);
    }
}
