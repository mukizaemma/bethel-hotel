<div class="public-livewire-page">

@include('frontend.includes.page-hero-banner', [
    'defaultCaption' => 'Contact Us',
    'defaultDescription' => "We'd love to help you plan your stay or event in Rubengera",
    'showHeroContacts' => true,
])

@php
    $setting = $setting ?? \App\Models\Setting::first();
    $rooms = $rooms ?? collect();
@endphp

<section class="home-cta home-cta--bethel home-cta--contact-page rts__section section__padding">
    <div class="container">
        <header class="home-cta__intro home-cta__intro--bethel">
            <p class="home-cta__eyebrow">Get in touch</p>
            <h2 class="home-cta__title section__title">Contact Bethel Hotel</h2>
            <p class="home-cta__lead font-sm">
                Call, email, or send the form below — we respond to room, workshop, and meeting enquiries from Rubengera and across Rwanda.
            </p>
        </header>

        @include('frontend.includes.booking-enquiry-section', [
            'setting' => $setting,
            'rooms' => $rooms,
            'formId' => 'contact-page-enquiry',
            'badgeIcon' => 'fa-comments',
            'badgeText' => 'Send a message',
            'defaultEnquiryType' => 'general',
        ])
    </div>
</section>

</div>
