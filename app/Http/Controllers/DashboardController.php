<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;

class DashboardController extends Controller
{
    /**
     * Switch to a different dashboard
     */
    public function switchDashboard(Request $request)
    {
        $user = auth()->user();
        $dashboard = $request->input('dashboard');
        
        // Validate dashboard access
        $allowedDashboards = [];
        
        if ($user->isSuperAdmin()) {
            $allowedDashboards = ['content-management', 'super-admin'];
        } elseif ($user->isAdmin()) {
            $allowedDashboards = ['content-management'];
        }
        
        if (!in_array($dashboard, $allowedDashboards)) {
            return redirect()->back()->with('error', 'You do not have access to that dashboard.');
        }
        
        // Redirect to the selected dashboard
        switch ($dashboard) {
            case 'content-management':
                return redirect()->route('content-management.dashboard');
            case 'super-admin':
                return redirect()->route('content-management.dashboard'); // Super Admin uses content management
            default:
                return redirect(RouteServiceProvider::getDashboardRoute($user));
        }
    }
    
    /**
     * Get available dashboards for current user
     */
    public function getAvailableDashboards()
    {
        $user = auth()->user();
        $dashboards = [];
        
        if ($user->isSuperAdmin()) {
            $dashboards = [
                ['name' => 'Content Management', 'route' => 'content-management.dashboard', 'icon' => 'fa-cog', 'key' => 'content-management'],
            ];
        } elseif ($user->isAdmin()) {
            $dashboards = [
                ['name' => 'Content Management', 'route' => 'content-management.dashboard', 'icon' => 'fa-cog', 'key' => 'content-management'],
            ];
        }
        
        return response()->json($dashboards);
    }
}
