@php
    $setting = $setting ?? \App\Models\Setting::first();
@endphp
<div class="home-cta__panel home-cta__panel--map w-100">
    <div class="home-cta__map-head">
        <span class="home-cta__map-icon" aria-hidden="true"><i class="fa-solid fa-location-dot"></i></span>
        <div class="home-cta__map-head-text">
            <span class="home-cta__map-label">Visit us</span>
            <span class="home-cta__map-title">{{ $setting?->company ?? config('app.name') }}</span>
            @if(filled($setting?->address))
                <span class="home-cta__map-address">{{ $setting->address }}</span>
            @endif
        </div>
    </div>
    <div class="home-cta__map-frame">
        @include('frontend.includes.map-embed', ['setting' => $setting])
    </div>
</div>
