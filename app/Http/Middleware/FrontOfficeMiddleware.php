<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FrontOfficeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        
        if (!auth()->check() || (!$user->isFrontOffice() && !$user->isAccountant() && !$user->isAdmin() && !$user->isSuperAdmin())) {
            abort(403, 'Unauthorized access. Front Office access required.');
        }

        return $next($request);
    }
}
