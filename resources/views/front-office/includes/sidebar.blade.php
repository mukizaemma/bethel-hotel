@php
$setting = App\Models\Setting::first();
$currentRoute = request()->route()->getName();
@endphp

<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <img class="rounded-circle" src="{{ asset('storage/images') . ($setting->logo ?? '') }}" alt="" style="width: 40px; height: 40px;">
                <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
            </div>
            <div class="ms-3">
                {{-- <h6 class="mb-0">{{ $setting->company ?? 'Bethel Hotel' }}</h6> --}}
                <span>
                    @if(auth()->user()->isSuperAdmin())
                        <span class="badge bg-danger me-1">Super Admin</span>
                    @endif
                    Front Office Dashboard
                </span>
            </div>
        </div>
        <div class="navbar-nav w-100">
            {{-- FRONT OFFICE MENU - Only for Front Office users and Super Admin when on this dashboard --}}
            {{-- Front Office users see ONLY these menus --}}
            {{-- Super Admin (role_id=1) sees ONLY these menus when on Front Office dashboard --}}
            {{-- NO mixing with Content Management menus --}}
            
            <a href="{{ route('front-office.dashboard') }}" class="nav-item nav-link {{ $currentRoute == 'front-office.dashboard' ? 'active' : '' }}">
                <i class="fas fa-grip-horizontal me-2"></i>Dashboard
            </a>
            
            {{-- Front Office Features - ONLY these items, no mixing with other dashboards --}}
            <a href="{{ route('front-office.rooms') }}" class="nav-item nav-link {{ str_contains($currentRoute, 'front-office.rooms') ? 'active' : '' }}">
                <i class="fas fa-bed me-2"></i>Rooms
            </a>
            <a href="{{ route('front-office.reservations.calendar') }}" class="nav-item nav-link {{ str_contains($currentRoute, 'front-office.reservations.calendar') ? 'active' : '' }}">
                <i class="fas fa-calendar me-2"></i>Calendar
            </a>
            <a href="{{ route('front-office.inhouse') }}" class="nav-item nav-link {{ str_contains($currentRoute, 'front-office.inhouse') ? 'active' : '' }}">
                <i class="fas fa-users me-2"></i>In-House List
            </a>
            <a href="{{ route('front-office.reservations') }}" class="nav-item nav-link {{ str_contains($currentRoute, 'front-office.reservations') && !str_contains($currentRoute, 'calendar') ? 'active' : '' }}">
                <i class="fas fa-list me-2"></i>Reservations
            </a>
            <a href="{{ route('front-office.reports.sales') }}" class="nav-item nav-link {{ str_contains($currentRoute, 'front-office.reports') ? 'active' : '' }}">
                <i class="fas fa-chart-bar me-2"></i>Sales Reports
            </a>
            
            <hr>
            <a href="{{ route('logouts') }}" class="nav-item nav-link">
                <i class="fas fa-sign-out-alt me-2"></i>Logout
            </a>
        </div>
    </nav>
</div>
