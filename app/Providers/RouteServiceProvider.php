<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Get the dashboard route based on user role_id
     * role_id = 1: Super Admin (default: content management)
     * role_id = 2: Admin (content-management dashboard only)
     * role_id = 3: Guest (no admin dashboard)
     */
    public static function getDashboardRoute($user)
    {
        if (!$user) {
            return '/dashboard';
        }

        // Check by role_id first (more reliable)
        switch ($user->role_id) {
            case 1: // Super Admin
                return '/content-management/dashboard';
            case 2: // Admin
                return '/content-management/dashboard';
            case 3: // Normal user (guest role)
                return '/account';
            default:
                // Fallback to slug-based check for backward compatibility
                if ($user->role) {
                    $roleSlug = $user->role->slug;
                    switch ($roleSlug) {
                        case 'super-admin':
                            return '/content-management/dashboard';
                        case 'admin':
                            return '/content-management/dashboard';
                        case 'guest':
                            return '/account';
                    }
                }
                return '/dashboard';
        }
    }

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
