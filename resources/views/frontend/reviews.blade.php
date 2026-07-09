<div class="public-livewire-page">

@php
    $c = \App\Support\HotelChannels::all();
    $taWrite = $c['tripadvisor_write_review_url'] ?? '#';
    $googlePlace = $c['google_place_url'] ?? '#';
    $taHotel = $c['tripadvisor_hotel_url'] ?? '#';
    $embedG = $c['google_maps_embed_url'] ?? '';
    $taLocationId = $c['tripadvisor_location_id'] ?? '28135123';
    $bookingUrl = $c['booking_com_url'] ?? '#';
    $bookingWrite = $c['booking_com_write_review_url'] ?? null;
    $googleWrite = $c['google_write_review_url'] ?? ($googlePlace !== '#' ? $googlePlace : null);

    $bcScore = $c['booking_com_review_score'] ?? null;
    $bcCount = $c['booking_com_review_count'] ?? null;
    $bcSummary = $c['booking_com_review_summary'] ?? null;

    $taScore = $c['tripadvisor_review_score'] ?? null;
    $taCount = $c['tripadvisor_review_count'] ?? null;
    $taSummary = $c['tripadvisor_review_summary'] ?? null;

    $gScore = $c['google_review_score'] ?? null;
    $gCount = $c['google_review_count'] ?? null;
    $gSummary = $c['google_review_summary'] ?? null;

    $bookingScreenshotPath = 'storage/review-cards/booking-com.png';
    $taScreenshotPath = 'storage/review-cards/tripadvisor.png';
    $googleScreenshotPath = 'storage/review-cards/google.png';

    $hasBookingScreenshot = file_exists(public_path($bookingScreenshotPath));
    $hasTaScreenshot = file_exists(public_path($taScreenshotPath));
    $hasGoogleScreenshot = file_exists(public_path($googleScreenshotPath));

    $fmtScore = static function ($v, int $decimals = 1): string {
        return number_format((float) $v, $decimals, '.', ',');
    };
@endphp

@include('frontend.includes.page-hero-banner', [
    'defaultCaption' => 'Guest reviews',
    'defaultDescription' => 'Ratings from Booking.com, TripAdvisor, and Google — leave yours where it counts',
])

<div class="rts__section section__padding pb-0">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-9">
                <h2 class="mb-3">Reviews you can trust</h2>
                <p class="font-lg text-muted mb-0">
                    We don’t collect reviews on this website. Compare scores below (updated in <strong>Admin → Booking &amp; review links</strong>), then open each platform to read or write a review.
                </p>
            </div>
        </div>
    </div>
</div>

<div class="rts__section section__padding pt-4">
    <div class="container">
        <div class="row g-4 g-lg-4 align-items-stretch">

            {{-- Booking.com --}}
            <div class="col-lg-4">
                <div class="reviews-platform-card h-100 d-flex flex-column rounded-4 bg-white shadow-soft border-0 overflow-hidden">
                    <div class="px-3 px-lg-4 py-3 border-bottom bg-gradient-primary-subtle">
                        <div class="d-flex align-items-center gap-3 mb-1">
                            <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-white border" style="width:44px;height:44px;">
                                <i class="fa-solid fa-bed text-primary" style="font-size:1.2rem;" aria-hidden="true"></i>
                            </span>
                            <div>
                                <h3 class="h5 mb-0">Booking.com</h3>
                                @if(filled($bookingUrl) && $bookingUrl !== '#')
                                    <a href="{{ $bookingUrl }}" class="small text-decoration-none" target="_blank" rel="noopener noreferrer" data-no-spa-navigate>View property on Booking.com →</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="p-3 p-lg-4 flex-grow-1 d-flex flex-column gap-3">
                        @if($bcScore !== null || $bcCount !== null || filled($bcSummary))
                            <div class="external-review-stats rounded-3 border bg-light p-3 mb-1 shadow-xs">
                                @if($hasBookingScreenshot)
                                    <div class="ratio ratio-16x9 mb-3">
                                        <img
                                            src="{{ asset($bookingScreenshotPath) }}"
                                            alt="Booking.com reviews summary screenshot"
                                            class="img-fluid rounded-2 border"
                                            loading="lazy">
                                    </div>
                                @endif
                                @if($bcScore !== null)
                                    <p class="h2 mb-1 text-primary">{{ $fmtScore($bcScore) }}<span class="fs-6 text-muted fw-normal"> / 10</span></p>
                                @endif
                                @if($bcCount !== null)
                                    <p class="small text-muted mb-2">{{ number_format($bcCount) }} {{ $bcCount === 1 ? 'review' : 'reviews' }} (as shown on your property page)</p>
                                @endif
                                @if(filled($bcSummary))
                                    <p class="small mb-0">{{ $bcSummary }}</p>
                                @endif
                            </div>
                        @else
                            <p class="small text-muted mb-3">Add score, count, or a short summary in Settings so guests see your Booking.com reputation at a glance.</p>
                        @endif
                        <p class="small text-muted mb-0 mt-1">
                            Booking.com shows guest scores and reviews on the property listing. Writing a review is usually via their post-stay invitation for verified guests.
                        </p>
                    </div>
                    <div class="px-3 px-lg-4 py-3 mt-auto border-top bg-light d-grid gap-2">
                        @if(filled($bookingUrl) && $bookingUrl !== '#')
                            <a href="{{ $bookingUrl }}" class="theme-btn btn-style fill w-100 text-center" target="_blank" rel="noopener noreferrer" data-no-spa-navigate>
                                <span>Open Booking.com listing</span>
                            </a>
                        @endif
                        @if(filled($bookingWrite))
                            <a href="{{ $bookingWrite }}" class="theme-btn btn-style border w-100 text-center" target="_blank" rel="noopener noreferrer" data-no-spa-navigate>
                                <span>Write a review on Booking.com</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- TripAdvisor --}}
            <div class="col-lg-4">
                <div class="reviews-platform-card h-100 d-flex flex-column rounded-4 bg-white shadow-soft border-0 overflow-hidden">
                    <div class="px-3 px-lg-4 py-3 border-bottom bg-gradient-success-subtle">
                        <div class="d-flex align-items-center gap-3 mb-1">
                            <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-white border" style="width:44px;height:44px;">
                                <i class="fa-brands fa-tripadvisor text-success" style="font-size:1.35rem;" aria-hidden="true"></i>
                            </span>
                            <div>
                                <h3 class="h5 mb-0">TripAdvisor</h3>
                                <a href="{{ $taHotel }}" class="small text-decoration-none" target="_blank" rel="noopener noreferrer" data-no-spa-navigate>See all reviews on TripAdvisor →</a>
                            </div>
                        </div>
                    </div>
                    @if($taScore !== null || $taCount !== null || filled($taSummary))
                        <div class="px-3 px-lg-4 pt-3">
                            <div class="external-review-stats rounded-3 border bg-light p-3">
                                @if($hasTaScreenshot)
                                    <div class="ratio ratio-16x9 mb-3">
                                        <img
                                            src="{{ asset($taScreenshotPath) }}"
                                            alt="TripAdvisor reviews summary screenshot"
                                            class="img-fluid rounded-2 border"
                                            loading="lazy">
                                    </div>
                                @endif
                                @if($taScore !== null)
                                    <p class="h2 mb-1 text-success">{{ $fmtScore($taScore) }}<span class="fs-6 text-muted fw-normal"> / 5</span></p>
                                @endif
                                @if($taCount !== null)
                                    <p class="small text-muted mb-2">{{ number_format($taCount) }} {{ $taCount === 1 ? 'review' : 'reviews' }}</p>
                                @endif
                                @if(filled($taSummary))
                                    <p class="small mb-0">{{ $taSummary }}</p>
                                @endif
                            </div>
                        </div>
                    @endif
                    <div class="reviews-platform-card__widget flex-grow-1 p-3 p-lg-4 bg-white" style="min-height: 240px;">
                        <div id="TA_selfserveprop482" class="TA_selfserveprop">
                            <ul class="TA_links TA482" id="TA482"></ul>
                        </div>
                        <script async src="https://www.jscache.com/wejs?wtype=selfserveprop&amp;uniq=482&amp;locationId={{ $taLocationId }}&amp;lang=en&amp;rating=true&amp;nreviews=4&amp;reviews=4&amp;writereviewlink=false&amp;popIdx=true&amp;iswide=true&amp;border=true&amp;display_version=2"></script>
                    </div>
                    @if(filled($taWrite) && $taWrite !== '#')
                    <div class="px-3 px-lg-4 py-3 mt-auto border-top bg-light">
                        <a href="{{ $taWrite }}" class="theme-btn btn-style fill w-100 text-center" target="_blank" rel="noopener noreferrer" data-no-spa-navigate>
                            <span>Write a review on TripAdvisor</span>
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Google --}}
            <div class="col-lg-4">
                <div class="reviews-platform-card h-100 d-flex flex-column rounded-4 bg-white shadow-soft border-0 overflow-hidden">
                    <div class="px-3 px-lg-4 py-3 border-bottom bg-gradient-primary-subtle">
                        <div class="d-flex align-items-center gap-3 mb-1">
                            <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-white border" style="width:44px;height:44px;">
                                <i class="fa-brands fa-google text-primary" style="font-size:1.25rem;" aria-hidden="true"></i>
                            </span>
                            <div>
                                <h3 class="h5 mb-0">Google</h3>
                                <p class="small text-muted mb-0">Maps &amp; Business profile</p>
                            </div>
                        </div>
                    </div>
                    @if($gScore !== null || $gCount !== null || filled($gSummary))
                        <div class="px-3 px-lg-4 pt-3">
                            <div class="external-review-stats rounded-3 border bg-light p-3 mb-0 shadow-xs">
                                @if($hasGoogleScreenshot)
                                    <div class="ratio ratio-16x9 mb-3">
                                        <img
                                            src="{{ asset($googleScreenshotPath) }}"
                                            alt="Google reviews summary screenshot"
                                            class="img-fluid rounded-2 border"
                                            loading="lazy">
                                    </div>
                                @endif
                                @if($gScore !== null)
                                    <p class="h2 mb-1 text-primary">{{ $fmtScore($gScore) }}<span class="fs-6 text-muted fw-normal"> / 5</span></p>
                                @endif
                                @if($gCount !== null)
                                    <p class="small text-muted mb-2">{{ number_format($gCount) }} {{ $gCount === 1 ? 'review' : 'reviews' }}</p>
                                @endif
                                @if(filled($gSummary))
                                    <p class="small mb-0">{{ $gSummary }}</p>
                                @endif
                            </div>
                        </div>
                    @endif
                    <div class="ratio ratio-4x3 border-bottom bg-light">
                        @if(filled($embedG))
                            <iframe
                                title="Hotel on Google Maps"
                                src="{{ $embedG }}"
                                class="border-0"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-light text-muted small p-4">
                                Set map embed URL in Admin → Booking &amp; review links.
                            </div>
                        @endif
                    </div>
                    <div class="px-3 px-lg-4 py-3 mt-auto border-top bg-light d-grid gap-2">
                        @if(filled($googlePlace) && $googlePlace !== '#')
                            <a href="{{ $googlePlace }}" class="theme-btn btn-style fill w-100 text-center" target="_blank" rel="noopener noreferrer" data-no-spa-navigate>
                                <span>Open Google Maps — listing</span>
                            </a>
                        @endif
                        @if(filled($googleWrite))
                            <a href="{{ $googleWrite }}" class="theme-btn btn-style border w-100 text-center" target="_blank" rel="noopener noreferrer" data-no-spa-navigate>
                                <span>Write a review on Google</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="rts__section section__padding pt-2 pb-5" style="background: linear-gradient(180deg, #f8fafc 0%, #fff 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <p class="text-center text-muted small mb-3">Need a room or have another question?</p>
                @include('frontend.includes.hotel-booking-channels', ['contextLabel' => ' (guest reviews page)'])
            </div>
        </div>
    </div>
</div>


@include('frontend.includes.page-booking-cta')
</div>
