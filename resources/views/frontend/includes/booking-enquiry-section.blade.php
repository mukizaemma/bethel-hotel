@props([
    'setting' => null,
    'rooms' => null,
    'formId' => 'booking-enquiry-form',
    'badgeIcon' => 'fa-calendar-check',
    'badgeText' => 'Enquiry form',
    'defaultEnquiryType' => null,
    'gridClass' => '',
])

@php
    $setting = $setting ?? \App\Models\Setting::first();
    $rooms = $rooms ?? collect();
@endphp

<div class="home-cta__bethel-grid {{ $gridClass }}">
    <aside class="home-cta__bethel-aside">
        @include('frontend.includes.booking-contact-details', ['setting' => $setting])
        <div class="home-cta__bethel-map" aria-label="Map showing hotel location">
            @include('frontend.includes.map-embed', ['setting' => $setting])
        </div>
    </aside>

    <div class="home-cta__bethel-form-panel">
        <div class="home-cta__form-badge home-cta__form-badge--bethel">
            <i class="fa-solid {{ $badgeIcon }}" aria-hidden="true"></i>
            <span>{{ $badgeText }}</span>
        </div>
        @include('frontend.includes.booking-enquiry-form', [
            'rooms' => $rooms,
            'setting' => $setting,
            'formId' => $formId,
            'defaultEnquiryType' => $defaultEnquiryType,
        ])
    </div>
</div>
