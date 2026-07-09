<!DOCTYPE html>
<html lang="zxx">
<base href='/public'>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="description" content="{{$setting?->company ?? ''}}">
    <meta name="keywords" content="{{$setting?->keywords ?? ''}}">
    <meta name="robots" content="@yield('meta_robots', 'index, follow')">
    <link rel="sitemap" type="application/xml" title="Sitemap" href="{{ url('/sitemap.xml') }}">
    <link rel="dns-prefetch" href="https://fonts.googleapis.com">
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- for open graph social media -->
    <meta property="og:title" content="{{$setting?->company ?? ''}}">
    <meta property="og:description" content="{{$setting?->company ?? ''}}">
    <!-- for twitter sharing -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{$setting?->company ?? ''}}">
    <meta name="twitter:description" content="{{$setting?->company ?? ''}}">
    <!-- favicon -->
    @php
        $brandLogo = filled($setting?->logo)
            ? asset('storage/images') . $setting->logo
            : asset('storage/images/bethel-logo.png');
        $footerLogo = filled($setting?->donate)
            ? asset('storage/images') . $setting->donate
            : $brandLogo;
    @endphp
    <link rel="icon" href="{{ $brandLogo }}" type="image/png">
    <!-- title -->
    <title>@hasSection('document_title')@yield('document_title')@else{{ $setting?->company ?? '' }}@endif</title>
    @stack('head')
    @php
        $gaMeasurementId = strtoupper(trim((string) ($setting->ga4_measurement_id ?? '')));
        $gaMeasurementId = preg_match('/^G-[A-Z0-9]+$/', $gaMeasurementId) === 1 ? $gaMeasurementId : null;
    @endphp
    @if($gaMeasurementId)
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaMeasurementId }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $gaMeasurementId }}');
        </script>
    @endif

    <!-- google fonts - Uniform, readable fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- icon font from flaticon -->
    <link rel="stylesheet" href="assets/fonts/flaticon_bokinn.css">
    <!-- all plugin css -->
    <link rel="stylesheet" href="assets/css/plugins.min.css">
    <!-- main style custom css -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/bethel-brand.css">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    @livewireStyles
    
    <style>
        /* Uniform font styling */
        :root {
            --brand-primary: #0048ff;
            --brand-primary-dark: #0036c9;
            --brand-secondary: #228b22;
            --brand-secondary-dark: #1a6b1a;
            --brand-black: #111111;
            --swiper-theme-color: var(--brand-primary);
        }
        a.text-primary,
        .text-primary {
            color: var(--brand-primary) !important;
        }
        body {
            font-family: 'Inter', sans-serif;
            font-size: 16px;
            line-height: 1.6;
            color: #1a1a1a;
            background: #ffffff;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Inter', sans-serif;
            font-weight: 700;
            line-height: var(--lh-heading, 1.25);
            color: var(--brand-black);
        }
        .site-footer--lux .footer__social-chip:hover {
            transform: translateY(-3px);
        }
        .site-footer--lux .footer__social-chip .fa-facebook-f { transform: translateX(1px); }
        .site-footer--lux .footer__social-chip .fa-linkedin-in { transform: translateX(1px); }
        .copyright__wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        /* Pagination: single row, normal-sized arrows, no overlap */
        .gallery-pagination-wrapper .pagination {
            display: inline-flex;
            flex-wrap: wrap;
            gap: 2px;
            align-items: center;
        }
        .gallery-pagination-wrapper .page-item .page-link {
            font-size: 0.875rem;
            padding: 0.35rem 0.65rem;
            min-width: auto;
            text-align: center;
        }
        .gallery-pagination-wrapper .page-item.disabled .page-link,
        .gallery-pagination-wrapper .page-item.active .page-link {
            cursor: default;
        }
        /* Header top bar — logo green ring */
        .header__top {
            background: var(--brand-secondary);
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
        }
        .header__top .link__item {
            color: rgba(255, 255, 255, 0.95);
            font-size: 14px;
            font-weight: 500;
        }
        .header__top .link__item:hover {
            color: #ffffff;
        }
        .header__top .link__item i {
            color: rgba(255, 255, 255, 0.95);
        }
        .header__social {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-left: 14px;
        }
        .header__social a {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--brand-primary);
            background: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.45);
            transition: all .25s ease;
        }
        .header__social a:hover {
            background: rgba(255, 255, 255, 0.92);
            color: var(--brand-primary-dark);
            transform: translateY(-1px);
        }
        .main__logo .logo__class,
        .offcanvase__logo img,
        .footer__logo {
            height: auto;
            max-height: 110px;
            width: auto;
            object-fit: contain;
        }
        .main__header {
            background: #ffffff;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
        }
        .main__header .navigation__menu--item__link {
            font-size: 18px;
            font-weight: 600;
            letter-spacing: 0.2px;
            color: #111111;
        }
        .main__header .navigation__menu--item__link:hover {
            color: var(--brand-primary);
        }
        .main__right .theme-btn {
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 72, 255, 0.22);
        }
        .main__right .theme-btn.fill {
            background: var(--brand-primary) !important;
            border-color: var(--brand-primary) !important;
        }
        /* Phone + email beside logo on small screens (top bar is hidden <576px) */
        .main__header__contacts {
            font-size: 0.7rem;
            line-height: 1.2;
            max-width: min(56vw, 14rem);
        }
        .main__header__contacts a {
            color: #111111;
            display: flex;
            align-items: flex-start;
            gap: 0.25rem;
            text-decoration: none;
            font-weight: 500;
        }
        .main__header__contacts a:hover {
            color: var(--brand-primary);
        }
        .main__header__contacts .main__header__contacts-icon {
            color: var(--brand-primary);
            flex-shrink: 0;
            margin-top: 1px;
            font-size: 0.65rem;
        }
        .main__header__contacts span.text-truncate {
            display: inline-block;
            max-width: 100%;
            vertical-align: bottom;
        }
        /* Home hero: full viewport height, same for every slide */
        .livewire-home-page .banner__area.is__home__one.banner__height {
            min-height: 100vh;
            min-height: 100dvh;
            padding-block: 0;
        }
        .livewire-home-page .banner__area.is__home__one .banner__slider {
            min-height: 100vh;
            min-height: 100dvh;
        }
        .livewire-home-page .banner__area.is__home__one .banner__slider .swiper-wrapper {
            min-height: 100vh;
            min-height: 100dvh;
        }
        .livewire-home-page .banner__area.is__home__one .banner__slider .swiper-slide {
            position: relative;
            min-height: 100vh;
            min-height: 100dvh;
            height: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            box-sizing: border-box;
        }
        .livewire-home-page .banner__slider__image {
            z-index: 0;
        }
        .livewire-home-page .banner__area.is__home__one .swiper-slide > .container {
            position: relative;
            z-index: 2;
            width: 100%;
            pointer-events: none;
        }
        .livewire-home-page .banner__area.is__home__one .swiper-slide > .container a {
            pointer-events: auto;
        }
        .livewire-home-page .banner__slide__content {
            padding-top: clamp(4rem, 12vh, 9rem);
            padding-bottom: clamp(4rem, 12vh, 9rem);
        }
        .livewire-home-page .banner__slider__image img,
        .livewire-home-page .banner__slider__image video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }
        /* Custom preloader: logo + animation (overrides template default) */
        .loader-wrapper {
            background: linear-gradient(145deg, #f8f9fa 0%, #ffffff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .loader-wrapper .loader-section.section-left,
        .loader-wrapper .loader-section.section-right {
            display: none;
        }
        .loader-wrapper .loader {
            width: auto;
            height: auto;
            top: auto;
            left: auto;
            transform: none;
            position: relative;
            border: none;
        }
        .loader-wrapper .loader:after {
            display: none;
        }
        .preloader-inner {
            text-align: center;
            position: relative;
            z-index: 1001;
        }
        .preloader-logo-wrap {
            position: relative;
            display: inline-block;
        }
        .preloader-logo-wrap:before {
            content: '';
            position: absolute;
            inset: -12px;
            border: 2px solid rgba(34, 139, 34, 0.35);
            border-radius: 50%;
            animation: preloader-ring 1.8s ease-in-out infinite;
        }
        .preloader-logo {
            max-width: 160px;
            width: 160px;
            height: auto;
            display: block;
            animation: preloader-logo-in 1s ease-out forwards, preloader-logo-pulse 2.2s ease-in-out 1s infinite;
            opacity: 0;
        }
        @keyframes preloader-logo-in {
            0% { opacity: 0; transform: scale(0.88); }
            100% { opacity: 1; transform: scale(1); }
        }
        @keyframes preloader-logo-pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.04); opacity: 0.95; }
        }
        @keyframes preloader-ring {
            0%, 100% { transform: scale(0.95); opacity: 0.4; }
            50% { transform: scale(1.08); opacity: 0.15; }
        }
        .loaded .loader-wrapper {
            opacity: 0;
            visibility: hidden;
            transform: none;
            transition: opacity 0.5s ease-out 0.15s, visibility 0.5s 0.15s;
        }
    </style>

</head>

<body>

        @if (session('swal'))
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                var swalOpts = @json(session('swal'));
                if (swalOpts && typeof swalOpts === 'object') {
                    if (!swalOpts.confirmButtonColor) {
                        swalOpts.confirmButtonColor = (swalOpts.icon === 'error') ? '#d33' : '#0048ff';
                    }
                    Swal.fire(swalOpts);
                }
            });
        </script>
    @elseif (session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: @json(session('success')),
                    confirmButtonColor: '#0048ff'
                });
            });
        </script>
    @endif

    @if (!session('swal') && session('error'))
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: @json(session('error')),
                    confirmButtonColor: '#d33'
                });
            });
        </script>
    @endif

    <!-- header area -->
    @php
        $hotelContactHeader = \App\Models\HotelContact::first();
        $receptionPhoneHeader = trim((string) ($setting?->reception_phone ?? ''));
        $headerPhone = filled($receptionPhoneHeader)
            ? $receptionPhoneHeader
            : ($hotelContactHeader?->phone ?? $setting?->phone ?? '');
        $headerEmail = $hotelContactHeader?->email ?? $setting?->email ?? '';
        $headerWhatsappDigits = '';
        if (filled(trim((string) ($setting?->whatsapp_e164 ?? '')))) {
            $headerWhatsappDigits = preg_replace('/\D+/', '', (string) $setting->whatsapp_e164);
        } elseif (filled($receptionPhoneHeader)) {
            $headerWhatsappDigits = preg_replace('/\D+/', '', $receptionPhoneHeader);
        } elseif ($hotelContactHeader && filled($hotelContactHeader->whatsapp)) {
            $headerWhatsappDigits = preg_replace('/\D+/', '', $hotelContactHeader->whatsapp);
        }
        $headerWhatsappLabel = filled($receptionPhoneHeader)
            ? $receptionPhoneHeader
            : (($hotelContactHeader && filled($hotelContactHeader->whatsapp))
                ? $hotelContactHeader->whatsapp
                : trim((string) ($setting?->whatsapp_e164 ?? '')));
        $headerAddress = '';
        if ($hotelContactHeader) {
            $headerAddress = trim(implode(' ', array_filter([
                $hotelContactHeader->address,
                $hotelContactHeader->city,
                $hotelContactHeader->country,
                $hotelContactHeader->postal_code,
            ])));
        }
        if ($headerAddress === '') {
            $headerAddress = $setting?->address ?? '';
        }
        $headerMapUrl = $headerAddress !== ''
            ? 'https://www.google.com/maps/search/?api=1&query=' . urlencode($headerAddress)
            : 'https://maps.app.goo.gl/HHpJhzWDsh4JCiVCA';
        $headerSocialLinks = array_values(array_filter(
            [
                ['url' => $hotelContactHeader?->facebook ?? $setting?->facebook, 'icon' => 'fab fa-facebook-f', 'label' => 'Facebook'],
                ['url' => $hotelContactHeader?->instagram ?? $setting?->instagram, 'icon' => 'fab fa-instagram', 'label' => 'Instagram'],
                ['url' => $hotelContactHeader?->twitter ?? $setting?->twitter, 'icon' => 'fab fa-twitter', 'label' => 'Twitter'],
                ['url' => $setting?->youtube, 'icon' => 'fab fa-youtube', 'label' => 'YouTube'],
                ['url' => $hotelContactHeader?->linkedin ?? $setting?->linkedin, 'icon' => 'fab fa-linkedin-in', 'label' => 'LinkedIn'],
            ],
            static function ($item) {
                return filled(trim((string) ($item['url'] ?? '')));
            }
        ));
    @endphp
    @persist('site-header')
    <div class="header__top">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-7 col-md-12">
                    <div class="social__links d-flex align-items-center flex-wrap gap-2">
                        @if(filled($headerPhone))
                        <a class="link__item gap-10" href="tel:{{ preg_replace('/\s+/', '', $headerPhone) }}"><i class="flaticon-phone-flip"></i> {{ $headerPhone }}</a>
                        @endif
                        @if(filled($headerWhatsappDigits))
                        <a class="link__item gap-10" href="https://wa.me/{{ $headerWhatsappDigits }}" target="_blank" rel="noopener noreferrer" title="WhatsApp"><i class="fab fa-whatsapp" style="color:#25D366"></i> {{ $headerWhatsappLabel }}</a>
                        @endif
                        @if(filled($headerEmail))
                        <a class="link__item gap-10" href="mailto:{{ $headerEmail }}"><i class="flaticon-envelope"></i> {{ $headerEmail }}</a>
                        @endif
                        @if(count($headerSocialLinks) > 0)
                        <div class="header__social">
                            @foreach($headerSocialLinks as $social)
                                <a href="{{ trim($social['url']) }}" target="_blank" rel="noopener noreferrer" aria-label="{{ $social['label'] }}">
                                    <i class="{{ $social['icon'] }}"></i>
                                </a>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-5 col-md-12 mt-2 mt-lg-0">
                    <div class="location text-lg-end text-md-start">
                        @if(filled($headerAddress))
                        <a class="link__item gap-10" href="{{ $headerMapUrl }}" target="_blank" rel="noopener noreferrer"><i class="flaticon-marker"></i>{{ $headerAddress }}</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <header class="main__header header__function">
        <div class="container">
            <div class="row">
                <div class="main__header__wrapper">
                    <div class="d-flex align-items-center min-w-0 flex-shrink-1 gap-2">
                        <div class="main__logo">
                            <a wire:navigate href="{{ route('home')}}"><img class="logo__class" src="{{ $brandLogo }}" alt="{{ $setting?->company ?? 'Bethel Hotel' }}" width="110px"></a>
                        </div>
                        @if((filled($headerPhone) || filled($headerEmail)))
                        <div class="main__header__contacts d-flex d-sm-none flex-column justify-content-center gap-1 text-start min-w-0" aria-label="Contact shortcuts">
                            @if(filled($headerPhone))
                            <a class="link__item" href="tel:{{ preg_replace('/\s+/', '', $headerPhone) }}">
                                <i class="fas fa-phone main__header__contacts-icon" aria-hidden="true"></i>
                                <span class="text-truncate">{{ $headerPhone }}</span>
                            </a>
                            @endif
                            @if(filled($headerEmail))
                            <a class="link__item" href="mailto:{{ $headerEmail }}">
                                <i class="fas fa-envelope main__header__contacts-icon" aria-hidden="true"></i>
                                <span class="text-truncate">{{ $headerEmail }}</span>
                            </a>
                            @endif
                        </div>
                        @endif
                    </div>
                    <div class="main__nav">
                        <div class="navigation d-none d-lg-block">
                            <nav class="navigation__menu" id="main__menu">
                                <ul class="list-unstyled">

                                    <li class="navigation__menu--item">
                                        <a wire:navigate.hover href="{{ route('home') }}" class="navigation__menu--item__link">Home</a>
                                    </li>

                                    <li class="navigation__menu--item has-child">
                                        <a wire:navigate.hover href="{{ route('about') }}" class="navigation__menu--item__link">About</a>
                                        <ul class="submenu sub__style" role="menu">
                                            <li role="menuitem"><a wire:navigate.hover href="{{ route('about')}}#background">Our History</a></li>
                                            <li role="menuitem"><a wire:navigate.hover href="{{ route('our-services') }}">Our Services</a></li>
                                            <li role="menuitem"><a wire:navigate.hover href="{{ route('terms')}}">Terms & Conditions</a></li>
                                            <li role="menuitem"><a wire:navigate.hover href="{{ route('our-team') }}">Our Team</a></li>
                                            <li role="menuitem"><a wire:navigate.hover href="{{ route('updates') }}">Updates</a></li>
                                            <li role="menuitem"><a wire:navigate.hover href="{{ route('contact')}}">Contacts</a></li>
                                        </ul>
                                    </li>

                                    <li class="navigation__menu--item">
                                        <a wire:navigate.hover href="{{ route('rooms')}}" class="navigation__menu--item__link"> Rooms</a>
                                    </li>
                                    <li class="navigation__menu--item">
                                        <a wire:navigate.hover href="{{ route('dining')}}" class="navigation__menu--item__link">Bar & Restaurant</a>
                                    </li>

                                    <li class="navigation__menu--item">
                                        <a wire:navigate.hover href="{{ route('meetings-events')}}" class="navigation__menu--item__link">Meetings & Events</a>
                                    </li>

                                    {{-- <li class="navigation__menu--item">
                                        <a wire:navigate.hover href="{{ route('spa-wellness')}}" class="navigation__menu--item__link">SPA & Wellness</a>
                                    </li> --}}

                                    <li class="navigation__menu--item">
                                        <a wire:navigate.hover href="{{ route('gallery')}}" class="navigation__menu--item__link">Gallery</a>
                                    </li>

                                    <li class="navigation__menu--item">
                                        <a wire:navigate.hover href="{{ route('contact')}}" class="navigation__menu--item__link">Contact</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>

                    </div>

                    <div class="main__right d-flex align-items-center gap-2 flex-wrap justify-content-end">
                        @auth
                            @if(auth()->user()->isGuest())
                                <a wire:navigate href="{{ route('account.dashboard') }}" class="theme-btn btn-style sm-btn outline" style="font-size: 14px; font-weight: 600; padding: 10px 20px;">
                                    <span>My account</span>
                                </a>
                            @elseif(auth()->user()->isAdmin())
                                <a wire:navigate href="{{ route('content-management.dashboard') }}" class="theme-btn btn-style sm-btn outline" style="font-size: 14px; font-weight: 600; padding: 10px 20px;">
                                    <span>Admin</span>
                                </a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}" class="d-inline m-0">
                                @csrf
                                <button type="submit" class="theme-btn btn-style sm-btn outline border-0" style="font-size: 14px; font-weight: 600; padding: 10px 20px; background: transparent;">
                                    Logout
                                </button>
                            </form>
                        @endauth
                        <a wire:navigate href="{{ route('connect') }}" class="theme-btn btn-style sm-btn fill" style="font-size: 16px; font-weight: 600; padding: 12px 30px;">
                            <span>Book Now</span>
                        </a>
                        <button class="theme-btn btn-style sm-btn fill menu__btn d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                            <span><img src="assets/images/icon/menu-icon.svg" alt=""></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- header area end -->


    <div class="container-fluid">
        @isset($slot)
            {{ $slot }}
        @else
            @yield('content')
        @endisset
    </div>


    <div class="modal similar__modal fade " id="loginModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="max-content similar__form form__padding">
                    <div class="d-flex mb-3 align-items-center justify-content-between">
                        <h6 class="mb-0">Sign in to {{ $setting?->company ?? 'Bethel Hotel' }}</h6>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <form action="candidate-dashboard.html" method="post" class="d-flex flex-column gap-3">
                        <div class="form-group">
                            <label for="email-popup" class="text-dark mb-3">Your Email</label>
                            <div class="position-relative">
                                <input type="email" name="email-popup" id="email-popup" placeholder="Enter your email" required>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="text-dark mb-3">Password</label>
                            <div class="position-relative">
                                <input type="password" name="password" id="password" placeholder="Enter your password" required>

                            </div>
                        </div>
                        <div class="d-flex flex-wrap justify-content-between align-items-center ">
                            <div class="form-check d-flex align-items-center gap-2">
                                <input class="form-check-input mt-0" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label mb-0" for="flexCheckDefault">
                                    Remember me
                                </label>
                            </div>
                            <a href="#" class="forgot__password text-para" data-bs-toggle="modal" data-bs-target="#forgotModal">Forgot Password?</a>
                        </div>
                        <div class="form-group my-3">
                            <button class="theme-btn btn-style sm-btn fill w-100"><span>Login</span></button>
                        </div>
                    </form>
                    <div class="d-block has__line text-center">
                        <p>Or</p>
                    </div>
                    <div class="d-flex gap-4 flex-wrap justify-content-center mt-20 mb-20">
                        <div class="is__social google">
                            <button class="theme-btn btn-style sm-btn"><span>Continue with Google</span></button>
                        </div>
                        <div class="is__social facebook">
                            <button class="theme-btn btn-style sm-btn"><span>Continue with Facebook</span></button>
                        </div>
                    </div>
                    <span class="d-block text-center ">Don`t have an account? <a href="#" data-bs-target="#signupModal" data-bs-toggle="modal" class="text-primary">Sign Up</a> </span>
                </div>
            </div>
        </div>
    </div>

    <!-- signup form -->
    <div class="modal similar__modal fade " id="signupModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="max-content similar__form form__padding">
                    <div class="d-flex mb-3 align-items-center justify-content-between">
                        <h6 class="mb-0">Create A Free Account</h6>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>

                    <form action="#" class="d-flex flex-column gap-3">
                        <div class="form-group">
                            <label for="sname" class=" text-dark mb-3">Your Name</label>
                            <div class="position-relative">
                                <input type="text" name="sname" id="sname" placeholder="Candidate" required>
                                <i class="fa-light fa-user icon"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="signemail" class=" text-dark mb-3">Your Email</label>
                            <div class="position-relative">
                                <input type="email" name="signemail" id="signemail" placeholder="Enter your email" required>
                                <i class="fa-sharp fa-light fa-envelope icon"></i>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="spassword" class=" text-dark mb-3">Password</label>
                            <div class="position-relative">
                                <input type="password" name="spassword" id="spassword" placeholder="Enter your password" required>
                                <i class="fa-light fa-lock icon"></i>
                            </div>
                        </div>

                        <div class="form-group my-3">
                            <button class="theme-btn btn-style sm-btn fill w-100"><span>Register</span></button>
                        </div>
                    </form>
                    <div class="d-block has__line text-center">
                        <p>Or</p>
                    </div>
                    <div class="d-flex flex-wrap justify-content-center gap-4 mt-20 mb-20">
                        <div class="is__social google">
                            <button class="theme-btn btn-style sm-btn"><span>Continue with Google</span></button>
                        </div>
                        <div class="is__social facebook">
                            <button class="theme-btn btn-style sm-btn"><span>Continue with Facebook</span></button>
                        </div>
                    </div>
                    <span class="d-block text-center ">Have an account? <a href="#" data-bs-target="#loginModal" data-bs-toggle="modal" class="text-primary">Login</a> </span>
                </div>
            </div>
        </div>
    </div>

    <!-- forgot password form -->
    <div class="modal similar__modal fade " id="forgotModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="max-content similar__form form__padding">
                    <div class="d-flex mb-3 align-items-center justify-content-between">
                        <h6 class="mb-0">Forgot Password</h6>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <form action="#" class="d-flex flex-column gap-3">
                        <div class="form-group">
                            <label for="fmail" class=" text-dark mb-3">Your Email</label>
                            <div class="position-relative">
                                <input type="email" name="email" id="fmail" placeholder="Enter your email" required>
                                <i class="fa-sharp fa-light fa-envelope icon"></i>
                            </div>
                        </div>
                        <div class="form-group my-3">
                            <button class="theme-btn btn-style sm-btn fill w-100"><span>Reset Password</span></button>
                        </div>
                    </form>

                    <span class="d-block text-center ">Remember Your Password? 
                <a href="#" data-bs-target="#loginModal" data-bs-toggle="modal" class="text-primary">Login</a> </span>
                </div>
            </div>
        </div>
    </div>

    <!-- offcanvase menu -->
    <div class="offcanvas offcanvas-start" id="offcanvasRight">
        <div class="rts__btstrp__offcanvase">
            <div class="offcanvase__wrapper">
                <div class="left__side mobile__menu">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    <div class="offcanvase__top">
                        <div class="offcanvase__logo">
                            <a wire:navigate href="{{ route('home')}}">
                                <img src="{{ $brandLogo }}" alt="{{ $setting?->company ?? 'Bethel Hotel' }}" height="110px">
                            </a>
                        </div>
                        <p class="description">
                            
                        </p>
                    </div>
                    <div class="offcanvase__mobile__menu">
                        <div class="mobile__menu__active"></div>
                    </div>
                    {{-- <div class="offcanvase__bottom">
                        <div class="offcanvase__address">

                            <div class="item">
                                <span class="h6">Phone</span>
                                <a href="tel:+1234567890"><i class="flaticon-phone-flip"></i> +1234567890</a>
                            </div>
                            <div class="item">
                                <span class="h6">Email</span>
                                <a href="mailto:info@hostie.com"><i class="flaticon-envelope"></i>info@hostie.com</a>
                            </div>
                            <div class="item">
                                <span class="h6">Address</span>
                                <a href="#"><i class="flaticon-marker"></i> {{$setting?->address?? ''}}</a>
                            </div>

                        </div>
                    </div> --}}
                </div>
                <div class="right__side desktop__menu">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    <div class="rts__desktop__menu">
                        <nav class="desktop__menu offcanvas__menu">
                            <ul class="list-unstyled">
                                <li class="slide has__children">
                                    <a wire:navigate class="slide__menu__item" href="{{ route('home') }}">Home
                                        <span class="toggle"></span>
                                    </a>
                                </li>
                                <li class="slide has__children">
                                    <a wire:navigate class="slide__menu__item" href="{{ route('about') }}">About us
                                        <span class="toggle"></span>
                                    </a>
                                    <ul class="slide__menu">
                                        <li><a wire:navigate href="{{ route('about') }}#background">Background</a></li>
                                        <li><a wire:navigate href="{{ route('our-services') }}">Our Services</a></li>
                                        <li><a wire:navigate href="{{ route('terms') }}">Terms & Conditions</a></li>
                                        <li><a wire:navigate href="{{ route('our-team') }}">Our Team</a></li>
                                        <li><a wire:navigate href="{{ route('contact') }}">Contacts</a></li>
                                        <li><a wire:navigate href="{{ route('updates') }}">Updates</a></li>
                                    </ul>
                                </li>
                                <li class="slide has__children">
                                    <a wire:navigate class="slide__menu__item" href="{{ route('rooms') }}">Rooms
                                        <span class="toggle"></span>
                                    </a>
                                    <ul class="slide__menu">
                                      @foreach ($rooms as $room)
                                        <li><a wire:navigate href="{{ route('room',['slug'=>$room->slug]) }}">{{ $room->title }}</a></li>
                                      @endforeach
                                        
                                    </ul>
                                </li>
                                <li class="slide">
                                    <a wire:navigate class="slide__menu__item" href="{{ route('dining') }}">Bar &amp; Restaurant</a>
                                </li>
                                <li class="slide">
                                    <a wire:navigate class="slide__menu__item" href="{{ route('meetings-events') }}">Meetings &amp; Events</a>
                                </li>
                                <li class="slide has__children">
                                    <a wire:navigate class="slide__menu__item" href="{{ route('gallery') }}">Gallery
                                        <span class="toggle"></span>
                                    </a>
                                </li>
                                <li class="slide">
                                    <a wire:navigate class="slide__menu__item" href="{{ route('contact') }}">Contact
                                    </a>
                                </li>
                                <li class="slide has__children">
                                    <a wire:navigate class="slide__menu__item" href="{{ route('connect') }}">Book Now
                                    </a>

                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- offcanvase menu end -->
    @endpersist

    @if(! request()->routeIs('home') && ! request()->routeIs('meetings-events') && ! request()->routeIs('handover'))
        @include('layouts.includes.why-choose-us')
    @endif

    <!-- footer style one -->
    @persist('site-footer')
    <footer class="rts__section rts__footer is__common__footer footer__background has__shape site-footer--lux">
        <div class="section__shape">
            {{-- <div class="shape__1">
                <img src="assets/images/footer/shape-1.svg" alt="">
            </div> --}}
            {{-- <div class="shape__2">
                <img src="assets/images/footer/shape-2.svg" alt="">
            </div> --}}
            <div class="shape__3">
                <img src="assets/images/footer/shape-3.svg" alt="">
            </div>
        </div>
        <div class="container">
            {{-- <div class="row">
                <div class="footer__newsletter">
                    <span class="h2">Join Our Newsletter</span>
                    <div class="rts__form">
                        <form action="#" method="post">
                            <input type="email" name="email" id="subscription" placeholder="Enter your mail" required>
                            <button type="submit">Subscribe</button>
                        </form>
                    </div>
                </div>
            </div> --}}
            <div class="row">
                <div class="footer__widget__wrapper footer__widget__wrapper--bethel">
                    <div class="rts__widget footer__brand">
                        <a wire:navigate href="{{ route('home')}}"><img class="footer__logo" src="{{ $footerLogo }}" alt="{{ $setting?->company ?? 'Bethel Hotel' }}" width="120"></a>
                        @php
                            $footerStars = isset($setting?->star_rating) ? (int) $setting->star_rating : 0;
                        @endphp
                        @if($footerStars >= 1 && $footerStars <= 5)
                        <div class="footer__stars" role="img" aria-label="{{ $footerStars }} out of 5 stars">
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="footer__star {{ $i <= $footerStars ? 'footer__star--on' : 'footer__star--off' }}" aria-hidden="true">
                                    <i class="fa-solid fa-star"></i>
                                </span>
                            @endfor
                        </div>
                        @endif
                        @if(filled($setting?->quote))
                        <p class="font-sm footer__mission mt-20">
                            {{ $setting->quote }}
                        </p>
                        @endif
                    </div>
                    <div class="rts__widget footer__widget--links">
                        <span class="widget__title">{{ $facilities->isNotEmpty() ? 'Hotel Facilities' : 'Quick Links' }}</span>
                        <ul>
                            @if($facilities->isNotEmpty())
                                @foreach ($facilities as $facility)
                                    <li><a wire:navigate href="{{ route('facility',['slug'=>$facility->slug]) }}" aria-label="footer__link">{{ $facility->title }}</a></li>
                                @endforeach
                            @else
                                <li><a wire:navigate href="{{ route('rooms') }}">Our Rooms</a></li>
                                <li><a wire:navigate href="{{ route('meetings-events') }}">Meetings &amp; Events</a></li>
                                <li><a wire:navigate href="{{ route('dining') }}">Bar &amp; Restaurant</a></li>
                                <li><a wire:navigate href="{{ route('gallery') }}">Gallery</a></li>
                                <li><a wire:navigate href="{{ route('contact') }}">Contact</a></li>
                            @endif
                        </ul>
                    </div>
                    <div class="rts__widget footer__widget--amenities">
                        <span class="widget__title">Our General Amenities</span>
                        @php
                            $footerAmenities = [
                                ['label' => '24/7 Security', 'icon' => 'fa-solid fa-shield-halved'],
                                ['label' => 'Free Parking', 'icon' => 'fa-solid fa-square-parking'],
                                ['label' => 'Free Wi-Fi', 'icon' => 'fa-solid fa-wifi'],
                                // ['label' => 'Transport Facility', 'icon' => 'fa-solid fa-shuttle-van'],
                                ['label' => 'Conference & Meeting Rooms', 'icon' => 'fa-solid fa-people-group'],
                            ];
                        @endphp
                        <ul class="footer-amenities" role="list">
                            @foreach($footerAmenities as $amenity)
                                <li class="footer-amenities__item">
                                    <span class="footer-amenities__icon" aria-hidden="true">
                                        <i class="{{ $amenity['icon'] }}"></i>
                                    </span>
                                    <span class="footer-amenities__label">{{ $amenity['label'] }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="rts__widget footer__widget--contact">
                        <span class="widget__title">Contact Us</span>
                        @php
                            $ftHotel = \App\Models\HotelContact::first();
                            $receptionPhone  = $setting?->reception_phone ?? null;
                            $managerPhone    = $setting?->manager_phone ?? null;
                            $restaurantPhone = $setting?->restaurant_phone ?? null;
                            $mainPhone = $ftHotel?->phone ?? $setting?->phone ?? '';
                            $mainEmail = $ftHotel?->email ?? $setting?->email ?? '';
                            $ftAddr = '';
                            if ($ftHotel) {
                                $parts = array_unique(array_filter([
                                    $ftHotel->address,
                                    $ftHotel->city,
                                    $ftHotel->country,
                                    $ftHotel->postal_code,
                                ]));
                                $ftAddr = trim(implode(', ', $parts));
                            }
                            if ($ftAddr === '') {
                                $ftAddr = $setting?->address ?? '';
                            }
                            $ftMapUrl = $ftAddr !== ''
                                ? 'https://www.google.com/maps/search/?api=1&query=' . urlencode($ftAddr)
                                : 'https://maps.app.goo.gl/HHpJhzWDsh4JCiVCA';
                            $socialLinks = [];
                            $socialRaw = [
                                [$ftHotel?->facebook ?? $setting?->facebook, 'fab fa-facebook-f', 'Facebook', '#1877F2'],
                                [$ftHotel?->twitter ?? $setting?->twitter, 'fab fa-twitter', 'Twitter', '#1DA1F2'],
                                [$ftHotel?->instagram ?? $setting?->instagram, 'fab fa-instagram', 'Instagram', 'linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%)'],
                                [$setting?->youtube, 'fab fa-youtube', 'YouTube', '#FF0000'],
                                [$ftHotel?->linkedin ?? $setting?->linkedin, 'fab fa-linkedin-in', 'LinkedIn', '#0077B5'],
                            ];
                            foreach ($socialRaw as $row) {
                                if (filled(trim((string) ($row[0] ?? '')))) {
                                    $socialLinks[] = ['url' => trim((string) $row[0]), 'icon' => $row[1], 'label' => $row[2], 'color' => $row[3]];
                                }
                            }
                        @endphp
                        <ul class="footer-contact-list">
                            @if($receptionPhone)
                                <li>
                                    <a href="tel:{{ preg_replace('/\s+/', '', $receptionPhone) }}" class="footer-contact-list__a">
                                        <span class="footer-contact-list__icon" aria-hidden="true"><i class="fa-solid fa-phone"></i></span>
                                        <span><span class="footer-contact-list__muted">Reception</span> {{ $receptionPhone }}</span>
                                    </a>
                                </li>
                            @endif
                            @if($managerPhone)
                                <li>
                                    <a href="tel:{{ preg_replace('/\s+/', '', $managerPhone) }}" class="footer-contact-list__a">
                                        <span class="footer-contact-list__icon" aria-hidden="true"><i class="fa-solid fa-phone"></i></span>
                                        <span><span class="footer-contact-list__muted">Manager</span> {{ $managerPhone }}</span>
                                    </a>
                                </li>
                            @endif
                            @if($restaurantPhone)
                                <li>
                                    <a href="tel:{{ preg_replace('/\s+/', '', $restaurantPhone) }}" class="footer-contact-list__a">
                                        <span class="footer-contact-list__icon" aria-hidden="true"><i class="fa-solid fa-phone"></i></span>
                                        <span><span class="footer-contact-list__muted">Restaurant</span> {{ $restaurantPhone }}</span>
                                    </a>
                                </li>
                            @endif
                            @if(!$receptionPhone && !$managerPhone && !$restaurantPhone && filled($mainPhone))
                                <li>
                                    <a href="tel:{{ preg_replace('/\s+/', '', $mainPhone) }}" class="footer-contact-list__a">
                                        <span class="footer-contact-list__icon" aria-hidden="true"><i class="fa-solid fa-phone"></i></span>
                                        <span>{{ $mainPhone }}</span>
                                    </a>
                                </li>
                            @endif
                            @php
                                $footerWhatsappDigits = '';
                                if (filled(trim((string) ($setting->whatsapp_e164 ?? '')))) {
                                    $footerWhatsappDigits = preg_replace('/\D+/', '', (string) $setting->whatsapp_e164);
                                } elseif (filled(trim((string) ($setting->reception_phone ?? '')))) {
                                    $footerWhatsappDigits = preg_replace('/\D+/', '', (string) $setting->reception_phone);
                                } elseif ($ftHotel && filled($ftHotel->whatsapp)) {
                                    $footerWhatsappDigits = preg_replace('/\D+/', '', $ftHotel->whatsapp);
                                }
                                $footerWhatsappLabel = filled(trim((string) ($setting->reception_phone ?? '')))
                                    ? trim((string) $setting->reception_phone)
                                    : (($ftHotel && filled($ftHotel->whatsapp))
                                        ? $ftHotel->whatsapp
                                        : trim((string) ($setting->whatsapp_e164 ?? '')));
                            @endphp
                            @if(filled($footerWhatsappDigits))
                                <li>
                                    <a href="https://wa.me/{{ $footerWhatsappDigits }}" target="_blank" rel="noopener noreferrer" class="footer-contact-list__a">
                                        <span class="footer-contact-list__icon footer-contact-list__icon--wa" aria-hidden="true"><i class="fab fa-whatsapp"></i></span>
                                        <span>{{ $footerWhatsappLabel }}</span>
                                    </a>
                                </li>
                            @endif
                            @if(filled($mainEmail))
                                <li>
                                    <a href="mailto:{{ $mainEmail }}" class="footer-contact-list__a">
                                        <span class="footer-contact-list__icon" aria-hidden="true"><i class="fa-solid fa-envelope"></i></span>
                                        <span class="footer-contact-list__break">{{ $mainEmail }}</span>
                                    </a>
                                </li>
                            @endif
                            @if(filled($ftAddr))
                                <li>
                                    <a href="{{ $ftMapUrl }}" target="_blank" rel="noopener noreferrer" class="footer-contact-list__a">
                                        <span class="footer-contact-list__icon" aria-hidden="true"><i class="fa-solid fa-location-dot"></i></span>
                                        <span>{{ $ftAddr }}</span>
                                    </a>
                                </li>
                            @endif
                        </ul>

                        @if(count($socialLinks) > 0)
                            <div class="footer__social__link footer__social__link--chips mt-4">
                                @foreach($socialLinks as $social)
                                    <a href="{{ $social['url'] }}"
                                       aria-label="{{ $social['label'] }}"
                                       class="footer__social-chip"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       style="background: {{ $social['color'] }};">
                                        <i class="{{ $social['icon'] }}" aria-hidden="true"></i>
                                    </a>
                                @endforeach
                            </div>
                        @endif

                        <div class="mt-3 footer__reviews">
                            <a wire:navigate href="{{ route('reviews') }}" class="footer__reviews-link" title="See reviews and ratings from Booking.com, TripAdvisor, and Google.">
                                <span class="footer__reviews-cta">All reviews &amp; ratings</span>
                            </a>
                        </div>

                        <div class="footer__book-wrap mt-4">
                            <a wire:navigate href="{{ route('connect') }}" class="footer__book-cta">
                                <span>Book Now</span>
                                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright__text">
            <div class="container">
                <div class="row">
                    <div class="copyright__wrapper" style="display: flex; flex-direction: column; align-items: center; text-align: center;">
                        <p class="mb-0">
                            © {{ date('Y') }} {{ $setting?->company }}. All rights reserved.
                            @if($setting?->footer_delivered_by_enabled && filled(trim((string) ($setting->footer_delivered_by_company ?? ''))))
                                Delivered by
                                @php
                                    $creditUrl = trim((string) ($setting->footer_delivered_by_url ?? ''));
                                    $creditName = trim((string) $setting->footer_delivered_by_company);
                                @endphp
                                @if($creditUrl !== '' && filter_var($creditUrl, FILTER_VALIDATE_URL))
                                    <a href="{{ $creditUrl }}" target="_blank" rel="noopener noreferrer">{{ $creditName }}</a>.
                                @else
                                    {{ $creditName }}.
                                @endif
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer style one end -->
    @endpersist
    <!-- back to top -->
    <button type="button" class="rts__back__top" id="rts-back-to-top">
        <svg width="20" height="20" viewBox="0 0 13 22" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7.30201 1.51317L7.29917 21.3422C7.29912 21.7057 6.97211 21.9993 6.5674 21.9993C6.16269 21.9992 5.83577 21.7055 5.83582 21.342L5.83844 3.10055L1.39753 7.08842C1.11169 7.34511 0.647535 7.34506 0.361762 7.0883C0.0759894 6.83155 0.0760493 6.41464 0.361896 6.15795L6.05367 1.04682C6.26405 0.857899 6.5773 0.802482 6.85167 0.905201C7.12374 1.00792 7.30205 1.24823 7.30201 1.51317Z" fill="#FFF" />
            <path d="M12.9991 6.6318C12.9991 6.80021 12.9282 6.96861 12.7841 7.09592C12.4983 7.35261 12.0341 7.35256 11.7483 7.0958L6.05118 1.97719C5.76541 1.72043 5.76547 1.30352 6.05131 1.04684C6.33716 0.790152 6.80131 0.790206 7.08709 1.04696L12.7842 6.16557C12.9283 6.29498 12.9991 6.46339 12.9991 6.6318Z" fill="#FFF" />
        </svg>

    </button>
    <!-- back to top end -->


    <!-- Custom preloader: animated logo -->
    <div class="loader-wrapper" id="site-preloader">
        <div class="loader">
            <div class="preloader-inner">
                <div class="preloader-logo-wrap">
                    <img src="{{ $brandLogo }}" alt="{{ $setting?->company ?? 'Bethel Hotel' }}" class="preloader-logo">
                </div>
            </div>
        </div>
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>
    <!-- Preloader end -->


    <!-- plugin js -->
    <script src="assets/js/plugins.min.js"></script>
    <script src="assets/js/gdpr.js"></script>
    <!-- custom js -->
    <script src="assets/js/main.js"></script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        window.showCookiePopup = {{ $showCookiePopup ?? true ? 'true' : 'false' }};
    </script>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
(function() {
    var applicationForm = document.getElementById('application-form');
    if (applicationForm) {
        applicationForm.addEventListener('submit', function(e) {
            e.preventDefault();
            var recaptchaResponse = grecaptcha.getResponse();
            if (!recaptchaResponse) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'reCAPTCHA',
                        text: 'Please confirm you are not a robot.',
                        confirmButtonColor: '#0048ff'
                    });
                } else {
                    alert("Please confirm you are not a robot.");
                }
                return false;
            }
            this.submit();
        });
    }
})();

    function initBookingDatePickers() {
        var checkIn = document.querySelector('#check__in');
        var checkOut = document.querySelector('#check__out');
        if (checkIn && typeof flatpickr !== 'undefined') {
            flatpickr('#check__in', { minDate: 'today', dateFormat: 'd M Y' });
        }
        if (checkOut && typeof flatpickr !== 'undefined') {
            flatpickr('#check__out', { minDate: 'today', dateFormat: 'd M Y' });
        }
    }
    initBookingDatePickers();
    document.addEventListener('livewire:navigated', initBookingDatePickers);

    function initWhyChooseJarallax() {
        if (typeof jQuery === 'undefined' || !jQuery.fn.jarallax) return;
        if (/Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) return;
        var $w = jQuery('.site-why-choose-parallax-wrap.jarallax');
        if (!$w.length) return;
        try { $w.jarallax('destroy'); } catch (e) {}
        $w.jarallax({ speed: 0.5 });
    }
    document.addEventListener('livewire:navigated', initWhyChooseJarallax);

    // Hide preloader immediately on SPA navigation (full HTML still swaps; avoids logo flash)
    document.addEventListener('livewire:navigating', function () {
        document.body.classList.add('loaded');
        var offcanvasEl = document.getElementById('offcanvasRight');
        if (offcanvasEl && typeof bootstrap !== 'undefined') {
            var instance = bootstrap.Offcanvas.getInstance(offcanvasEl);
            if (instance) instance.hide();
        }
    });

    function initHeroBannerSwiper() {
        if (typeof Swiper === 'undefined') return;

        var el = document.querySelector('.hero-banner-swiper');
        if (!el) return;

        if (el.swiper) {
            el.swiper.destroy(true, true);
        }

        var slideCount = el.querySelectorAll('.swiper-slide').length;
        if (slideCount === 0) return;

        new Swiper(el, {
            slidesPerView: 1,
            loop: slideCount > 1,
            speed: 900,
            effect: 'fade',
            fadeEffect: { crossFade: true },
            autoplay: slideCount > 1 ? {
                delay: 5500,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            } : false,
            navigation: {
                nextEl: el.querySelector('.hero-swiper-next'),
                prevEl: el.querySelector('.hero-swiper-prev'),
            },
            pagination: {
                el: el.querySelector('.hero-swiper-pagination'),
                clickable: true,
                dynamicBullets: true,
            },
        });
    }

    document.addEventListener('DOMContentLoaded', initHeroBannerSwiper);

    function initHomeRoomAndFacilitySwipers() {
        if (typeof Swiper === 'undefined') return;
        if (document.querySelector('.rooms-swiper') && !document.querySelector('.rooms-swiper.swiper-initialized')) {
            new Swiper('.rooms-swiper', {
                slidesPerView: 1,
                spaceBetween: 24,
                loop: true,
                speed: 700,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                },
                navigation: {
                    nextEl: '.rooms-swiper-button-next',
                    prevEl: '.rooms-swiper-button-prev',
                },
                pagination: {
                    el: '.rooms-swiper-pagination',
                    clickable: true,
                    dynamicBullets: true,
                },
                breakpoints: {
                    576: {
                        slidesPerView: 2,
                    },
                    992: {
                        slidesPerView: 2,
                    },
                },
            });
        }

        if (document.querySelector('.facilities-swiper') && !document.querySelector('.facilities-swiper.swiper-initialized')) {
            new Swiper('.facilities-swiper', {
                slidesPerView: 1,
                spaceBetween: 24,
                loop: true,
                speed: 700,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                },
                navigation: {
                    nextEl: '.facilities-swiper-button-next',
                    prevEl: '.facilities-swiper-button-prev',
                },
                pagination: {
                    el: '.facilities-swiper-pagination',
                    clickable: true,
                    dynamicBullets: true,
                },
                breakpoints: {
                    576: {
                        slidesPerView: 2,
                    },
                    992: {
                        slidesPerView: 2,
                    },
                },
            });
        }
    }

    // Home page Swiper carousels — run on first load and after Livewire navigations
    document.addEventListener('DOMContentLoaded', function () {
        initHomeRoomAndFacilitySwipers();
        initPageGalleries();
    });

    function initPageGalleries() {
        if (typeof Swiper === 'undefined') return;
        document.querySelectorAll('.page-gallery-root').forEach(function (root) {
            var mainEl = root.querySelector('.page-gallery-main');
            if (!mainEl || mainEl.classList.contains('swiper-initialized')) return;

            var key = root.getAttribute('data-gallery-id') || 'gallery';
            var slideCount = mainEl.querySelectorAll('.swiper-slide').length;
            if (slideCount === 0) return;

            var thumbEl = root.querySelector('.page-gallery-thumbs');
            var thumbsSwiper = null;
            if (thumbEl && !thumbEl.classList.contains('swiper-initialized') && thumbEl.querySelectorAll('.swiper-slide').length > 1) {
                thumbsSwiper = new Swiper(thumbEl, {
                    spaceBetween: 10,
                    slidesPerView: 4,
                    freeMode: true,
                    watchSlidesProgress: true,
                    slideToClickedSlide: true,
                    breakpoints: {
                        0: { slidesPerView: 3 },
                        576: { slidesPerView: 4 },
                        992: { slidesPerView: 5 },
                    },
                });
            }

            var prevEl = root.querySelector('.page-gallery-prev--' + key);
            var nextEl = root.querySelector('.page-gallery-next--' + key);
            var pagEl = root.querySelector('.page-gallery-pagination--' + key);

            var cfg = {
                slidesPerView: 1,
                spaceBetween: 0,
                speed: 600,
                loop: slideCount > 1,
                autoHeight: true,
                navigation: slideCount > 1 && prevEl && nextEl ? {
                    prevEl: prevEl,
                    nextEl: nextEl,
                } : undefined,
                pagination: pagEl ? {
                    el: pagEl,
                    clickable: true,
                    dynamicBullets: slideCount > 1,
                } : undefined,
            };

            if (thumbsSwiper) {
                cfg.thumbs = { swiper: thumbsSwiper };
            }

            new Swiper(mainEl, cfg);
        });
    }

    document.addEventListener('livewire:navigated', function () {
        initHeroBannerSwiper();
        initHomeRoomAndFacilitySwipers();
        initPageGalleries();
    });

</script>

    @stack('scripts')
    @livewireScriptConfig
    @livewireScripts

</body>

</html>