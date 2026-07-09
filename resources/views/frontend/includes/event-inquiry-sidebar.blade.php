{{--
  Meetings & events sidebar — WhatsApp / email (no web form).
  Expects: $formPrefix, $cardTitle, $cardLead, $iconClass (optional), $proposalSource (optional), $meetingRoomLabel (optional)
--}}
@php
    $pf = $formPrefix ?? 'inquiry';
    $icon = $iconClass ?? 'fa-solid fa-calendar-check';
    $source = $proposalSource ?? 'meetings';
    $meetingRoomLabel = isset($meetingRoomLabel) ? trim((string) $meetingRoomLabel) : '';
    $label = trim(($cardTitle ?? 'Enquiry').($meetingRoomLabel !== '' ? ' — '.$meetingRoomLabel : '').' ('.$source.')');
    $hotelName = $setting?->company ?? 'Bethel Hotel';
    $c = \App\Support\HotelChannels::all();
    $waDigits = preg_replace('/\D+/', '', (string) ($c['whatsapp_e164'] ?? ''));
    $waMsg = trim(($c['whatsapp_default_message'] ?? '').' '.$label);
    $waUrl = $waDigits !== '' ? 'https://wa.me/'.$waDigits.'?text='.rawurlencode($waMsg) : '#';
    $email = $c['public_email'] ?? 'centrebethel@ymail.com';
    $mailto = 'mailto:'.$email.'?subject='.rawurlencode('Events / '.$source.' — '.$hotelName);
@endphp
<aside class="page-inquiry-card w-100 wow fadeInUp" data-wow-delay=".08s" aria-labelledby="page-inquiry-title-{{ $pf }}">
    <div class="page-inquiry-card__inner">
        <div class="page-inquiry-card__head">
            <span class="page-inquiry-card__icon" aria-hidden="true"><i class="{{ $icon }}"></i></span>
            <h3 id="page-inquiry-title-{{ $pf }}" class="page-inquiry-card__title">{{ $cardTitle }}</h3>
            <p class="page-inquiry-card__lead font-sm">{{ $cardLead }}</p>
        </div>
        <p class="small text-muted mb-3">
            Tell us about your date and group size on <strong>WhatsApp</strong>, or email us — we’ll respond directly.
        </p>
        <div class="d-grid gap-2">
            <a href="{{ $c['booking_com_url'] ?? '#' }}" class="btn w-100 d-flex align-items-center justify-content-center gap-2 fw-semibold" style="background:#0048ff;border:1px solid #0048ff;color:#ffffff;" target="_blank" rel="noopener noreferrer" data-no-spa-navigate>
                <i class="fa-solid fa-bed" aria-hidden="true"></i>
                <span>Rooms on Booking.com</span>
            </a>
            <a href="{{ $waUrl }}" class="btn text-white w-100 d-flex align-items-center justify-content-center gap-2" style="background:#25D366;border-color:#25D366;" target="_blank" rel="noopener noreferrer" data-no-spa-navigate>
                <i class="fa-brands fa-whatsapp fa-lg" aria-hidden="true"></i>
                <span>Chat on WhatsApp</span>
            </a>
            <a href="{{ $mailto }}" class="btn btn-outline-primary w-100" data-no-spa-navigate>
                <i class="fa-solid fa-envelope me-2" aria-hidden="true"></i>{{ $email }}
            </a>
        </div>
    </div>
</aside>
