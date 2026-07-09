<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>My account — {{ config('app.name', 'Hotel') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --account-brand: #0048ff;
            --account-brand-dark: #0036c9;
            --account-accent: #228b22;
        }
        .account-sidebar {
            width: 280px;
            min-height: 100vh;
            background: #fff;
            border-right: 1px solid #e9ecef;
        }
        .account-sidebar .nav-link {
            color: #334155;
            border-radius: 8px;
            padding: 0.65rem 1rem;
            font-weight: 500;
        }
        .account-sidebar .nav-link:hover {
            background: #f1f5f9;
            color: var(--account-brand);
        }
        .account-sidebar .nav-link.active {
            background: rgba(3, 86, 183, 0.1);
            color: var(--account-brand);
            border-left: 3px solid var(--account-brand);
        }
        .account-sidebar .nav-link.text-danger:hover {
            color: #dc3545 !important;
            background: #fff5f5;
        }
        .account-main {
            flex: 1;
            min-width: 0;
        }
        .stat-card {
            border: 1px solid #e9ecef;
            border-radius: 12px;
            background: #fff;
        }
    </style>
    @livewireStyles
</head>
<body class="bg-light">
    <div class="d-flex flex-column flex-md-row min-vh-100">
        <aside class="account-sidebar p-4">
            <div class="text-center mb-4">
                @php $u = auth()->user(); @endphp
                <img src="{{ $u->profile_photo_url }}" alt="" class="rounded-circle border mb-2" width="72" height="72" style="object-fit:cover;">
                <div class="fw-semibold">{{ $u->name }}</div>
                <small class="text-muted text-break">{{ $u->email }}</small>
            </div>
            <nav class="nav flex-column gap-1">
                <a wire:navigate href="{{ route('account.dashboard') }}" class="nav-link {{ request()->routeIs('account.dashboard') ? 'active' : '' }}">
                    <i class="fa fa-th-large me-2"></i> Dashboard
                </a>
                <a wire:navigate href="{{ route('account.profile') }}" class="nav-link {{ request()->routeIs('account.profile') ? 'active' : '' }}">
                    <i class="fa fa-user me-2"></i> My Profile
                </a>
                <a wire:navigate href="{{ route('account.bookings') }}" class="nav-link {{ request()->routeIs('account.bookings*') ? 'active' : '' }}">
                    <i class="fa fa-calendar me-2"></i> My Bookings
                </a>
                <a wire:navigate href="{{ route('account.password') }}" class="nav-link {{ request()->routeIs('account.password') ? 'active' : '' }}">
                    <i class="fa fa-lock me-2"></i> Change Password
                </a>
                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button type="submit" class="nav-link text-danger border-0 bg-transparent w-100 text-start">
                        <i class="fa fa-sign-out-alt me-2"></i> Sign Out
                    </button>
                </form>
            </nav>
        </aside>
        <main class="account-main p-4">
            {{ $slot }}
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    @livewireScripts
</body>
</html>
