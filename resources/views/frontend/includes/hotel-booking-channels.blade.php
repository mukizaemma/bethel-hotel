{{--
  Replaces on-site booking/enquiry forms: Booking.com + WhatsApp + email.
  Optional: $contextLabel — appended to default WhatsApp message for context (e.g. room name).
--}}
@php
    $c = \App\Support\HotelChannels::all();
    $hotelName = $setting?->company ?? 'Bethel Hotel';
    $bookingUrl = $c['booking_com_url'] ?? '#';
    $waBase = (string) ($c['whatsapp_default_message'] ?? "Hello {$hotelName},");
    $waMsg = trim($waBase.' '.($contextLabel ?? ''));
    $waDigits = preg_replace('/\D+/', '', (string) ($c['whatsapp_e164'] ?? ''));
    $waUrl = $waDigits !== '' ? 'https://wa.me/'.$waDigits.'?text='.rawurlencode($waMsg) : '#';
    $email = $c['public_email'] ?? 'centrebethel@ymail.com';
    $mailto = 'mailto:'.$email.'?subject='.rawurlencode('Enquiry — '.$hotelName);
@endphp

<div class="hotel-channel-actions {{ $class ?? '' }}">
    <p class="hotel-channel-actions__lead small text-muted mb-3">
        Reservations are managed securely on <strong>Booking.com</strong>. For other questions, reach us on WhatsApp or email.
    </p>
    <div class="d-grid gap-2">
        @if(filled($bookingUrl) && $bookingUrl !== '#')
        <a href="{{ $bookingUrl }}" class="hotel-channel-actions__btn hotel-channel-actions__btn--booking theme-btn btn-style fill text-center" target="_blank" rel="noopener noreferrer">
            <i class="fa-solid fa-calendar-check me-2" aria-hidden="true"></i>
            <span>Book on Booking.com</span>
        </a>
        @endif
        <div class="row g-2">
            <div class="col-sm-6">
                <a href="{{ $waUrl }}" class="hotel-channel-actions__btn hotel-channel-actions__btn--wa btn w-100 d-inline-flex align-items-center justify-content-center gap-2" style="background:#25D366;border-color:#25D366;color:#fff;" target="_blank" rel="noopener noreferrer" data-no-spa-navigate>
                    <i class="fa-brands fa-whatsapp fa-lg" aria-hidden="true"></i>
                    <span>WhatsApp</span>
                </a>
            </div>
            <div class="col-sm-6">
                <a href="{{ $mailto }}" class="hotel-channel-actions__btn btn btn-outline-primary w-100 d-inline-flex align-items-center justify-content-center gap-2" data-no-spa-navigate>
                    <i class="fa-solid fa-envelope" aria-hidden="true"></i>
                    <span>Email us</span>
                </a>
            </div>
        </div>
    </div>
</div>
