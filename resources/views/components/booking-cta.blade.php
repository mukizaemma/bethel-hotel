@props([
    'rooms',
    'setting' => null,
    'eyebrow' => 'Plan your stay',
    'title' => 'Book or enquire',
    'lead' => 'Send us your dates and room preference — our team will confirm availability and rates. For instant online booking, use Booking.com (link in contact details).',
    'headingId' => 'booking-cta-heading',
    'showChildrenField' => false,
])

@php
    $setting = $setting ?? \App\Models\Setting::first();
    $rooms = $rooms ?? collect();
    $defaultEnquiryType = $rooms->isNotEmpty() ? 'room' : 'general';
@endphp

<section class="home-cta home-cta--bethel rts__section section__padding" aria-labelledby="{{ $headingId }}">
    <div class="container">
        <header class="home-cta__intro home-cta__intro--bethel wow fadeInUp">
            <p class="home-cta__eyebrow">{{ $eyebrow }}</p>
            <h2 id="{{ $headingId }}" class="home-cta__title section__title">{{ $title }}</h2>
            <p class="home-cta__lead font-sm">{{ $lead }}</p>
        </header>

        @include('frontend.includes.booking-enquiry-section', [
            'setting' => $setting,
            'rooms' => $rooms,
            'formId' => 'home-booking-enquiry',
            'badgeIcon' => 'fa-calendar-check',
            'badgeText' => 'Booking enquiry form',
            'defaultEnquiryType' => $defaultEnquiryType,
            'gridClass' => 'wow fadeInUp',
        ])
    </div>
</section>
