{{-- Expects: $pageHero (nullable), $about (nullable), $defaultCaption, $defaultDescription (optional) --}}
@php
    $heroCaption = $defaultCaption ?? 'Page';
    $heroDescription = $defaultDescription ?? '';
    $heroImage = '';
    $heroBackground = $pageHero->background_image ?? null;
    if (! filled($heroBackground)) {
        $defaultHero = \App\Models\PageHero::defaultHero();
        if ($defaultHero && $defaultHero->is_active && filled($defaultHero->background_image)) {
            $heroBackground = $defaultHero->background_image;
        }
    }
    if ($pageHero && filled($heroBackground)) {
        $heroImage = asset('storage/' . $heroBackground);
        $heroCaption = $pageHero->caption ?: $heroCaption;
        $heroDescription = $pageHero->description ?? $heroDescription;
    } elseif (filled($heroBackground)) {
        $heroImage = asset('storage/' . $heroBackground);
    } elseif ($about && $about->image2) {
        if (strpos($about->image2, '/') !== false || strpos($about->image2, 'abouts') === 0) {
            $heroImage = asset('storage/' . $about->image2);
        } else {
            $heroImage = asset('storage/images/about/' . $about->image2);
        }
    } else {
        $heroImage = asset('storage/images/about/default.jpg');
    }
@endphp
<div class="rts__section page__hero__height page__hero__bg" style="background-image: url({{ $heroImage }}); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-12">
                <div class="page__hero__content text-center">
                    <h1 class="wow fadeInUp">{{ $heroCaption }}</h1>
                    @if(filled($heroDescription))
                    <p class="wow fadeInUp font-sm mb-0">{{ $heroDescription }}</p>
                    @endif

                    @if($showHeroContacts ?? false)
                        @php
                            $hcHero = $hotelContact ?? \App\Models\HotelContact::first();
                            $stHero = $setting ?? \App\Models\Setting::first();
                            $heroReception = trim((string) ($stHero?->reception_phone ?? ''));
                            $heroEmail = $hcHero?->email ?? $stHero?->email ?? '';
                            $heroSocialLinks = array_values(array_filter(
                                [
                                    ['url' => $hcHero?->facebook ?? $stHero?->facebook, 'icon' => 'fab fa-facebook-f', 'label' => 'Facebook'],
                                    ['url' => $hcHero?->instagram ?? $stHero?->instagram, 'icon' => 'fab fa-instagram', 'label' => 'Instagram'],
                                    ['url' => $hcHero?->twitter ?? $stHero?->twitter, 'icon' => 'fab fa-twitter', 'label' => 'Twitter'],
                                    ['url' => $stHero?->youtube, 'icon' => 'fab fa-youtube', 'label' => 'YouTube'],
                                    ['url' => $hcHero?->linkedin ?? $stHero?->linkedin, 'icon' => 'fab fa-linkedin-in', 'label' => 'LinkedIn'],
                                ],
                                static function ($item) {
                                    return filled(trim((string) ($item['url'] ?? '')));
                                }
                            ));
                            $heroHasSocial = count($heroSocialLinks) > 0;
                            $heroWhatsappDigits = hotel_phone_digits($stHero?->whatsapp_e164 ?? '');
                            $heroWhatsappLabel = hotel_phone_display($stHero?->whatsapp_e164 ?? '');
                            $heroShowBlock = filled($heroReception) || filled($heroEmail) || filled($heroWhatsappDigits) || $heroHasSocial;
                        @endphp
                        @if($heroShowBlock)
                            <div class="page__hero__contacts wow fadeInUp" data-wow-delay="0.12s">
                                <div class="page__hero__contacts-row">
                                    @if(filled($heroReception))
                                        <a href="tel:{{ hotel_phone_digits($heroReception) }}"><i class="flaticon-phone-flip" aria-hidden="true"></i><span>Reception {{ $heroReception }}</span></a>
                                    @endif
                                    @if(filled($heroWhatsappDigits))
                                        <a href="https://wa.me/{{ $heroWhatsappDigits }}" target="_blank" rel="noopener noreferrer" title="WhatsApp"><i class="fab fa-whatsapp" aria-hidden="true"></i><span>WhatsApp {{ $heroWhatsappLabel }}</span></a>
                                    @endif
                                    @if(filled($heroEmail))
                                        <a href="mailto:{{ $heroEmail }}"><i class="flaticon-envelope" aria-hidden="true"></i><span>{{ $heroEmail }}</span></a>
                                    @endif
                                </div>
                                @if($heroHasSocial)
                                    <div class="page__hero__contacts-social">
                                        @foreach($heroSocialLinks as $social)
                                            <a href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer" aria-label="{{ $social['label'] }}"><i class="{{ $social['icon'] }}" aria-hidden="true"></i></a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
