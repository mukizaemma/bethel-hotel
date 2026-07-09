@php
    $hotelName = $setting?->company ?? 'Bethel Hotel';
    $c = \App\Support\HotelChannels::all();
    $waDigits = preg_replace('/\D+/', '', (string) ($c['whatsapp_e164'] ?? ''));
    $waUrl = $waDigits !== '' ? 'https://wa.me/'.$waDigits.'?text='.rawurlencode('Hello — I would like updates from '.$hotelName.'.') : '#';
    $email = $c['public_email'] ?? 'centrebethel@ymail.com';
@endphp
<div class="tp-cta__area mt-10" id="subscribe">
    <div class="tp-cta__bg wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".3s" data-background="assets/img/cta/cta-bg-3.jpg">
        <div class="container">
            <div class="row align-items-center justify-content-center text-center py-4">
                <div class="col-lg-8">
                    <h2 class="mb-2" style="color: #ad3303">Stay in touch</h2>
                    <p class="mb-4 text-muted">We don’t use a mailing list form here. Message us on WhatsApp or email for news and offers.</p>
                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        <a href="{{ $waUrl }}" class="btn text-white px-4" style="background:#25D366;" target="_blank" rel="noopener noreferrer" data-no-spa-navigate>
                            <i class="fa-brands fa-whatsapp me-2"></i>WhatsApp
                        </a>
                        <a href="mailto:{{ $email }}" class="btn btn-outline-light px-4" style="border-color:#ad3303;color:#ad3303;" data-no-spa-navigate>
                            <i class="fa-solid fa-envelope me-2"></i>{{ $email }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
