<div class="livewire-home-page">
<!-- Animated Slideshow Section -->
@include('frontend.includes.slides')
<!-- Slideshow End -->

<!-- About Us Section -->
<div class="rts__section about__area is__home__main section__padding" id="background" style="background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 50%, #f0f4f8 100%); position: relative; overflow: hidden;">
    <!-- Decorative Background Elements -->
    <div class="about__decorative-bg" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; opacity: 0.03; pointer-events: none;">
        <div style="position: absolute; top: -50px; right: -50px; width: 300px; height: 300px; background: radial-gradient(circle, #228b22 0%, transparent 70%); border-radius: 50%;"></div>
        <div style="position: absolute; bottom: -100px; left: -100px; width: 400px; height: 400px; background: radial-gradient(circle, #0048ff 0%, transparent 70%); border-radius: 50%;"></div>
    </div>
    

    
    <div class="container" style="position: relative; z-index: 1;">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="about__content-wrapper home-welcome-card" style="background: white; border-radius: 20px; padding: clamp(2rem, 4vw, 3rem) clamp(1.25rem, 4vw, 3.5rem); box-shadow: 0 10px 40px rgba(0,0,0,0.08), 0 2px 10px rgba(0,0,0,0.05); position: relative; overflow: hidden;">
                    <!-- Decorative Accent Line -->
                    <div style="position: absolute; top: 0; left: 0; right: 0; height: 5px; background: linear-gradient(90deg, #228b22 0%, #0048ff 50%, #228b22 100%);"></div>
                    
                    <div class="home-welcome__inner">
                        <!-- Title (centered) -->
                        <div class="text-center home-welcome__head">
                            <h2 class="wow fadeInUp" data-wow-delay=".2s" style="font-size: clamp(2rem, 4vw, 2.8rem); font-weight: 700; color: #111111; margin-bottom: 20px; line-height: 1.3; font-family: 'Inter', sans-serif;">
                                Welcome To <span style="color: #0048ff; position: relative;">
                                    {{ $setting?->company ?? 'Our Hotel' }}
                                    <span style="position: absolute; bottom: -5px; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, transparent 0%, #0048ff 20%, #0048ff 80%, transparent 100%); opacity: 0.3;"></span>
                                </span>
                            </h2>
                            <div class="wow fadeInUp" data-wow-delay=".3s" style="margin: 0 auto 28px; width: 80px; height: 4px; background: linear-gradient(90deg, transparent 0%, #0048ff 50%, transparent 100%); border-radius: 2px;"></div>
                        </div>
                        
                        <!-- Body: full width, left-aligned for readable columns -->
                        <div class="home-welcome__prose wow fadeInUp" data-wow-delay=".4s">
                            {!! $about?->founderDescription ?? '<p>Bethel Hotel is a 2-star hotel in Rubengera, Karongi — perfectly suited for workshops, seminars, and comfortable stays in Western Rwanda.</p>' !!}
                        </div>
                        
                        <div class="text-center home-welcome__cta wow fadeInUp" data-wow-delay=".5s" style="margin-top: 2.25rem;">
                            <a wire:navigate href="{{ route('about') }}" class="theme-btn btn-style fill no-border" style="display: inline-block; padding: 16px 45px; font-size: 16px; font-weight: 600; letter-spacing: 0.5px; text-transform: uppercase; box-shadow: 0 6px 20px rgba(0, 72, 255, 0.28); transition: all 0.3s ease; border-radius: 8px;">
                                <span>Learn More About Us</span>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Decorative Corner Elements -->
                    <div style="position: absolute; top: 20px; right: 20px; width: 100px; height: 100px; border-top: 2px solid rgba(34, 139, 34, 0.15); border-right: 2px solid rgba(34, 139, 34, 0.15); border-radius: 0 20px 0 0;"></div>
                    <div style="position: absolute; bottom: 20px; left: 20px; width: 100px; height: 100px; border-bottom: 2px solid rgba(0, 72, 255, 0.15); border-left: 2px solid rgba(0, 72, 255, 0.15); border-radius: 0 0 0 20px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- About Us End -->

<!-- Hotel Rooms Section -->
<div class="rts__section section__padding home-rooms-section" style="background: #f5f6f8;">
    <div class="container">
        <div class="row justify-content-center text-center mb-50 mb-lg-60">
            <div class="col-lg-8 wow fadeInUp">
                <div class="section__topbar">
                    <h2 class="section__title">Our Hotel Rooms</h2>
                    <p class="font-sm mb-0">Comfortable, affordable rooms for delegates and travellers</p>
                </div>
            </div>
        </div>

        @if($rooms->count() > 0)
        <div class="row g-4 g-lg-4 justify-content-center wow fadeInUp" data-wow-delay=".1s">
            @foreach($rooms->take(4) as $room)
            <div class="col-12 col-md-6">
                <article class="home-room-card">
                    <a wire:navigate href="{{ route('room', ['slug' => $room->slug]) }}" class="home-room-card__media">
                        <img src="{{ asset('storage/' . ($room->cover_image ?? 'rooms/default.jpg')) }}"
                            alt="{{ $room->title }}"
                            loading="lazy"
                            width="800"
                            height="480">
                    </a>
                    <div class="home-room-card__body">
                        <div class="home-room-card__head">
                            <a wire:navigate href="{{ route('room', ['slug' => $room->slug]) }}" class="home-room-card__title">{{ $room->title }}</a>
                            <div class="home-room-card__price">
                                <span class="home-room-card__price-from">Starts from</span>
                                <div class="home-room-card__price-line">
                                    <span class="home-room-card__price-amount">{{ hotel_price($room->price ?? 0, $setting) }}</span>
                                    <span class="home-room-card__price-unit">/ night</span>
                                </div>
                            </div>
                        </div>
                        <p class="home-room-card__excerpt">
                            {!! Str::words(strip_tags($room->description ?? ''), 28, '…') !!}
                        </p>
                        <div class="home-room-card__actions">
                            <a wire:navigate href="{{ route('room', ['slug' => $room->slug]) }}" class="theme-btn btn-style sm-btn border">
                                <span>View Details</span>
                            </a>
                            <a wire:navigate href="{{ route('room', ['slug' => $room->slug]) }}#booking" class="theme-btn btn-style sm-btn fill">
                                <span>Book Now</span>
                            </a>
                        </div>
                    </div>
                </article>
            </div>
            @endforeach
        </div>

        <div class="row mt-45 mt-lg-50">
            <div class="col-12 text-center">
                <a wire:navigate href="{{ route('rooms') }}" class="home-rooms-view-all theme-btn btn-style border">
                    <span>View all hotel rooms</span>
                </a>
            </div>
        </div>
        @else
        <p class="text-center text-muted mb-0">Rooms coming soon.</p>
        @endif
    </div>
</div>
<!-- Hotel Rooms End -->

    <!-- quote section (formerly video section) -->
    <div class="rts__section pb-120 video video__full" style="margin: 0; padding: 0; width: 100%; overflow: hidden; position: relative;">
        <div style="width: 100vw; position: relative; left: 50%; right: 50%; margin-left: -50vw; margin-right: -50vw; padding: 0;">
            <div class="video__area position-relative wow fadeInUp" style="width: 100%; margin: 0; padding: 0;">
                <div class="video__area__image jara-mask-2 jarallax rounded-0" style="width: 100%; padding: 0; border-radius: 0; margin: 0;"> 
                    @php
                        $image2Path = '';
                        if ($about && $about?->image2) {
                            if (strpos($about?->image2, '/') !== false || strpos($about?->image2, 'abouts') === 0) {
                                $image2Path = asset('storage/' . $about?->image2);
                            } else {
                                $image2Path = asset('storage/images/about/' . $about?->image2);
                            }
                        } else {
                            $image2Path = asset('storage/images/about/default.jpg');
                        }
                    @endphp
                    <img class="radius-none jarallax-img" src="{{ $image2Path }}" alt="Hotel Quote" loading="lazy" onerror="this.src='{{ asset('storage/images/about/default.jpg') }}'" style="width: 100%; height: 100%; object-fit: cover; display: block; margin: 0; padding: 0;">
                </div>
                <div class="video--spinner__wrapper" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 2; width: 80%; max-width: 80%; text-align: center;">
                    <blockquote class="home-quote-block" style="margin: 0; padding: 0; width: 100%; max-width: 100%; border: none; background: transparent;">
                        <p class="home-quote-text" style="margin: 0; font-size: clamp(1.5rem, 3.5vw, 2.5rem); font-weight: 500; line-height: 1.4; color: #fff; text-shadow: 0 2px 10px rgba(0,0,0,0.5); font-style: italic; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            &ldquo;{{ $about?->vision ?? 'Where comfort meets purpose — your ideal venue for workshops and meetings in Rubengera.' }}&rdquo;
                        </p>
                    </blockquote>
                </div>
            </div>
        </div>
    </div>
    <!-- quote section end -->

<!-- Our Services Section (facilities) — matches Our Hotel Rooms layout -->
<div class="rts__section section__padding home-services-section" style="background: #f5f6f8;">
    <div class="container">
        <div class="row justify-content-center text-center mb-50 mb-lg-60">
            <div class="col-lg-8 wow fadeInUp">
                <div class="section__topbar">
                    <h2 class="section__title">Our Services</h2>
                    <p class="font-sm mb-0">Practical facilities for workshops, dining, and your stay</p>
                </div>
            </div>
        </div>

        @if($homeFacilities->count() > 0)
        <div class="row g-4 g-lg-4 justify-content-center wow fadeInUp" data-wow-delay=".1s">
            @foreach($homeFacilities as $facility)
            <div class="col-12 col-md-6">
                <article class="home-room-card">
                    <a wire:navigate href="{{ route('facility', ['slug' => $facility->slug]) }}" class="home-room-card__media">
                        <img src="{{ asset('storage/' . ($facility->cover_image ?? 'facilities/default.jpg')) }}"
                            alt="{{ $facility->title }}"
                            loading="lazy"
                            width="800"
                            height="480">
                    </a>
                    <div class="home-room-card__body">
                        <div class="home-room-card__head home-room-card__head--title-only">
                            <a wire:navigate href="{{ route('facility', ['slug' => $facility->slug]) }}" class="home-room-card__title">{{ $facility->title }}</a>
                        </div>
                        <p class="home-room-card__excerpt">
                            {!! Str::words(strip_tags($facility->description ?? ''), 28, '…') !!}
                        </p>
                        <div class="home-room-card__actions">
                            <a wire:navigate href="{{ route('facility', ['slug' => $facility->slug]) }}" class="theme-btn btn-style sm-btn border">
                                <span>View details</span>
                            </a>
                            <a wire:navigate href="{{ route('contact') }}" class="theme-btn btn-style sm-btn fill">
                                <span>Contact us</span>
                            </a>
                        </div>
                    </div>
                </article>
            </div>
            @endforeach
        </div>

        <div class="row mt-45 mt-lg-50">
            <div class="col-12 text-center">
                <a wire:navigate href="{{ route('our-services') }}" class="home-rooms-view-all theme-btn btn-style border">
                    <span>View all services</span>
                </a>
            </div>
        </div>
        @else
        <p class="text-center text-muted mb-0">Services coming soon.</p>
        @endif
    </div>
</div>
<!-- Our Services End -->

<!-- Workshops & Meetings CTA -->
<div class="rts__section section__padding" style="background: linear-gradient(135deg, #0036c9 0%, #0048ff 55%, #228b22 100%);">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-7 text-white wow fadeInLeft">
                <p class="text-uppercase small mb-2" style="letter-spacing: 0.12em; opacity: 0.9;">Workshops &amp; meetings</p>
                <h2 class="section__title text-white mb-3">Host your next workshop or meeting in Rubengera</h2>
                <p class="font-sm mb-0" style="opacity: 0.95; max-width: 36rem;">
                    Flexible meeting spaces, catering support, and comfortable rooms for your delegates — ideal for trainings, seminars, church gatherings, and corporate events.
                </p>
            </div>
            <div class="col-lg-5 text-lg-end wow fadeInRight">
                <a wire:navigate href="{{ route('meetings-events') }}" class="theme-btn btn-style fill me-2 mb-2 mb-lg-0" style="background: #fff; color: #0048ff; border-color: #fff;">
                    <span>View meeting spaces</span>
                </a>
                <a wire:navigate href="{{ route('contact') }}" class="theme-btn btn-style border" style="border-color: rgba(255,255,255,0.7); color: #fff;">
                    <span>Request a proposal</span>
                </a>
            </div>
        </div>
    </div>
</div>
<!-- Workshops & Meetings CTA End -->

@include('layouts.includes.why-choose-us')

<!-- Updates/Blogs Section -->
@if($blogs && $blogs->count() > 0)
<div class="rts__section section__padding" style="background: #f9f9f9;">
    <div class="container">
        <div class="row position-relative justify-content-center text-center mb-60">
            <div class="col-lg-6 wow fadeInUp">
                <div class="section__topbar">
                    <h2 class="section__title">Latest Updates</h2>
                    <p class="font-sm">Stay informed with our latest news and updates</p>
                </div>
            </div>
        </div>
        <div class="row g-30">
            @foreach($blogs as $blog)
            <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".{{ $loop->index * 2 }}s">
                <div class="blog__card" style="background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                    <div style="height: 250px; overflow: hidden;">
                        <a wire:navigate href="{{ route('update', ['slug' => $blog->slug]) }}">
                            <img src="{{ asset('storage/images/blogs/' . ($blog->image ?? 'default.jpg')) }}" 
                                 alt="{{ $blog->title }}" 
                                 style="width: 100%; height: 100%; object-fit: cover;">
                        </a>
                    </div>
                    <div style="padding: 25px;">
                        <a wire:navigate href="{{ route('update', ['slug' => $blog->slug]) }}" class="h5" style="display: block; margin-bottom: 15px; color: #222;">
                            {{ $blog->title }}
                        </a>
                        <p class="font-sm" style="color: #666; margin-bottom: 15px;">
                            {!! Str::words(strip_tags($blog->body ?? ''), 25, '...') !!}
                        </p>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span class="font-sm" style="color: #999;">
                                {{ $blog->created_at->format('M d, Y') }}
                            </span>
                            <a wire:navigate href="{{ route('update', ['slug' => $blog->slug]) }}" class="theme-btn btn-style sm-btn border">
                                <span>Read More</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row mt-40">
            <div class="col-12 text-center">
                <a wire:navigate href="{{ route('updates') }}" class="theme-btn btn-style fill">
                    <span>View All Updates</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endif
<!-- Updates End -->

<x-booking-cta :rooms="$rooms" heading-id="home-cta-heading" :show-children-field="true" />
<!-- Call to Action End -->
</div>
