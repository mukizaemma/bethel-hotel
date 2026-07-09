@php
    $setting = $setting ?? \App\Models\Setting::first();
    $hc = \App\Models\HotelContact::first();
    $c = \App\Support\HotelChannels::all();
    $phone = $setting?->reception_phone ?? $hc?->phone ?? $setting?->phone ?? '';
    $email = $c['public_email'] ?? $setting?->email ?? $hc?->email ?? '';
    $waDigits = preg_replace('/\D+/', '', (string) ($c['whatsapp_e164'] ?? ''));
    $address = '';
    if ($hc) {
        $parts = array_unique(array_filter([$hc->address, $hc->city, $hc->country]));
        $address = implode(', ', $parts);
    }
    if ($address === '') {
        $address = (string) ($setting?->address ?? '');
    }
    $mapUrl = filled($address)
        ? 'https://www.google.com/maps/search/?api=1&query='.urlencode($address)
        : ($c['google_place_url'] ?? '#');
    $bookingUrl = $c['booking_com_url'] ?? null;
@endphp

<div class="bethel-contact-card">
    <p class="bethel-contact-card__eyebrow">Reach us directly</p>
    <h3 class="bethel-contact-card__title">{{ $setting?->company ?? 'Bethel Hotel' }}</h3>

    <ul class="bethel-contact-card__list">
        @if(filled($phone))
        <li>
            <span class="bethel-contact-card__icon bethel-contact-card__icon--phone" aria-hidden="true"><i class="fa-solid fa-phone"></i></span>
            <span class="bethel-contact-card__label">Reception</span>
            <a href="tel:{{ preg_replace('/\s+/', '', $phone) }}" class="bethel-contact-card__value">{{ $phone }}</a>
        </li>
        @endif
        @if(filled($email))
        <li>
            <span class="bethel-contact-card__icon bethel-contact-card__icon--email" aria-hidden="true"><i class="fa-solid fa-envelope"></i></span>
            <span class="bethel-contact-card__label">Email</span>
            <a href="mailto:{{ $email }}" class="bethel-contact-card__value">{{ $email }}</a>
        </li>
        @endif
        @if(filled($waDigits))
        <li>
            <span class="bethel-contact-card__icon bethel-contact-card__icon--wa" aria-hidden="true"><i class="fab fa-whatsapp"></i></span>
            <span class="bethel-contact-card__label">WhatsApp</span>
            <a href="https://wa.me/{{ $waDigits }}" target="_blank" rel="noopener noreferrer" class="bethel-contact-card__value" data-no-spa-navigate>{{ $phone ?: '+'.$waDigits }}</a>
        </li>
        @endif
        @if(filled($address))
        <li>
            <span class="bethel-contact-card__icon bethel-contact-card__icon--map" aria-hidden="true"><i class="fa-solid fa-location-dot"></i></span>
            <span class="bethel-contact-card__label">Address</span>
            <a href="{{ $mapUrl }}" target="_blank" rel="noopener noreferrer" class="bethel-contact-card__value">{{ $address }}</a>
        </li>
        @endif
    </ul>

    <p class="bethel-contact-card__hours"><i class="fa-regular fa-clock" aria-hidden="true"></i> Open 24 hours</p>

    @if(filled($bookingUrl) && $bookingUrl !== '#')
    <p class="bethel-contact-card__booking-note small mb-0">
        Instant room booking:
        <a href="{{ $bookingUrl }}" target="_blank" rel="noopener noreferrer" data-no-spa-navigate>Booking.com</a>
    </p>
    @endif
</div>
