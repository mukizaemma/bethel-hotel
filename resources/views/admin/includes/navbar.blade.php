<nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
    <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
        <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
    </a>
    <a href="#" class="sidebar-toggler flex-shrink-0">
        <i class="fa fa-bars"></i>
    </a>
    <form class="d-none d-md-flex ms-4">
        <input class="form-control border-0" type="search" placeholder="Search">
    </form>
    <div class="navbar-nav align-items-center ms-auto">
        @php
            $user = auth()->user();
            $currentRoute = request()->route()->getName();
            $currentDashboard = 'content-management';
        @endphp

        @php
            $setting = App\Models\Setting::first();
            $user = auth()->user();
            $avatarUrl = $user->profile_photo_path
                ? $user->profile_photo_url
                : (($setting && $setting->logo) ? asset('storage/images') . $setting->logo : $user->profile_photo_url);
        @endphp
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <img class="rounded-circle me-lg-2" src="{{ $avatarUrl }}" alt="{{ $user->name }}" style="width: 40px; height: 40px; object-fit: cover;">
                <span class="d-none d-lg-inline-flex">{{ auth()->user()->name }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                <div class="dropdown-header">
                    <strong>{{ auth()->user()->name }}</strong>
                    <br>
                    <small class="text-muted">{{ auth()->user()->role->name ?? 'No Role' }}</small>
                </div>
                <div class="dropdown-divider"></div>
                
                <h6 class="dropdown-header">Dashboard</h6>
                <a href="{{ route('content-management.dashboard') }}" class="dropdown-item {{ $currentDashboard == 'content-management' ? 'active' : '' }}">
                    <i class="fa fa-cog me-2"></i>Content Management
                    @if($currentDashboard == 'content-management')
                        <i class="fa fa-check float-end mt-1"></i>
                    @endif
                </a>
                <div class="dropdown-divider"></div>
                
                {{-- <a href="{{ route('aboutPage') }}" class="dropdown-item">
                    <i class="fa fa-user me-2"></i>My Profile
                </a> --}}
                <a href="{{ route('setting') }}" class="dropdown-item">
                    <i class="fa fa-cog me-2"></i>Settings
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('logouts') }}" class="dropdown-item">
                    <i class="fa fa-sign-out-alt me-2"></i>Log Out
                </a>
            </div>
        </div>
    </div>
</nav>