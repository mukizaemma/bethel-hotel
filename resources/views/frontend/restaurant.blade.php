<div class="public-livewire-page dining-page">

@include('frontend.includes.page-hero-banner', [
    'defaultCaption' => $restaurant->title ?? 'Dining',
    'defaultDescription' => 'Bed and breakfast, varied dishes, event catering, and garden dining in Rubengera.',
])

@php
    $galleryImages = $images ?? collect();
    $cuisineCards = isset($cuisines) ? $cuisines : collect();
    $cuisineSectionTitle = filled($restaurant->cuisine_section_title ?? null)
        ? $restaurant->cuisine_section_title
        : 'A table of many flavours';
    $cuisineLeadText = filled($restaurant->cuisine_section_lead ?? null)
        ? $restaurant->cuisine_section_lead
        : 'From Rwandan home cooking to international plates, our kitchen prepares meals for overnight guests, workshops, celebrations, and catering beyond the hotel.';

    $restaurantBgImage = filled($restaurant->image ?? null)
        ? (str_contains($restaurant->image, '/') ? asset('storage/'.$restaurant->image) : asset('storage/images/restaurant/'.$restaurant->image))
        : (filled($images?->first()?->image) ? asset('storage/images/restaurant/'.$images->first()->image) : null);

    $introHtml = filled($restaurant->description ?? null)
        ? $restaurant->description
        : '<p>Bethel Hotel offers an affordable bed-and-breakfast stay in Rubengera, with a restaurant and bar that welcome overnight guests, workshop groups, and visitors from the community. Meals are prepared with care — from breakfast through hearty lunches and dinners — in a green, quiet setting with strong internet for work, study, and rest.</p><p>Our chefs cook for events held here and also provide outside catering. Staying with us is a quiet home away from home, and part of the hotel’s income supports health insurance, education, and development work through the Rubengera Presbytery of the Presbyterian Church in Rwanda (Église Presbytérienne au Rwanda – EPR).</p>';

    $diningOffers = [
        ['icon' => 'fa-mug-saucer', 'title' => 'Bed & breakfast', 'text' => 'Start the day with a filling breakfast included in an affordable overnight stay — practical for delegates, families, and solo travellers.'],
        ['icon' => 'fa-bowl-food', 'title' => 'Many kinds of dishes', 'text' => 'Rwandan favourites and international plates, cooked fresh for the restaurant, bar, and group meals throughout the day.'],
        ['icon' => 'fa-calendar-check', 'title' => 'Cooking for events here', 'text' => 'Buffets and plated service for workshops, seminars, church gatherings, and celebrations on the hotel grounds.'],
        ['icon' => 'fa-truck', 'title' => 'Outside catering', 'text' => 'The same kitchen can cook for events off-site — ask us to plan menus, portions, and delivery for your occasion.'],
        ['icon' => 'fa-wifi', 'title' => 'Strong internet', 'text' => 'Reliable Wi‑Fi across the property so you can work, join online sessions, or stay connected during your stay.'],
        ['icon' => 'fa-leaf', 'title' => 'Green, quiet grounds', 'text' => 'Gardens and open space around the hotel make meals and rest more comfortable — a peaceful home away from home.'],
    ];
@endphp

<section class="page-feature rts__section section__padding dining-intro">
    <div class="container">
        <div class="row g-4 g-xl-5 align-items-stretch">
            <div class="col-lg-5 d-flex flex-column">
                <header class="page-feature__header mb-3">
                    <p class="page-feature__eyebrow">Restaurant, bar &amp; catering</p>
                    <h2 class="page-feature__title section__title">{{ $restaurant->title ?? 'Dining at Bethel Hotel' }}</h2>
                </header>
                <div class="page-feature__prose content-richtext dining-intro__copy mb-4">
                    {!! $introHtml !!}
                </div>
                <div class="dining-community__panel mt-auto">
                    <p class="page-feature__eyebrow mb-2">Faith, community &amp; a quiet stay</p>
                    <h2 class="h4 mb-3">A Christian-led hotel that gives back</h2>
                    <p class="mb-2">Bethel Hotel is an affordable place to stay for events, workshops, and individuals looking for a quiet home away from home. Guests enjoy green surroundings, community visits, and the calm of Rubengera near Lake Kivu.</p>
                    <p class="mb-3">A share of the hotel’s income supports health insurance, education, and local development projects through the <strong>Rubengera Presbytery of the Presbyterian Church in Rwanda</strong> (Église Presbytérienne au Rwanda – EPR).</p>
                    <a wire:navigate href="{{ route('about') }}" class="theme-btn btn-style fill d-inline-flex"><span>Our story</span></a>
                </div>
            </div>
            <div class="col-lg-7">
                @include('frontend.includes.page-gallery', [
                    'galleryImages' => $galleryImages,
                    'storageSubfolder' => 'restaurant',
                    'galleryKey' => 'dining',
                ])
            </div>
        </div>
    </div>
</section>

<section class="dining-offers rts__section">
    <div class="container">
        <div class="text-center mb-4 mb-lg-5">
            <p class="page-feature__eyebrow mb-2">What the kitchen offers</p>
            <h2 class="section__title mb-2">Eat well, stay connected, feel at home</h2>
            <p class="font-sm text-muted mx-auto" style="max-width: 38rem;">Affordable hospitality with Christian values — good food for overnight guests, workshops, and the wider Rubengera community.</p>
        </div>
        <div class="row g-3 g-lg-4">
            @foreach($diningOffers as $offer)
            <div class="col-md-6 col-lg-4">
                <article class="dining-offer-card h-100">
                    <span class="dining-offer-card__icon" aria-hidden="true"><i class="fa-solid {{ $offer['icon'] }}"></i></span>
                    <h3 class="dining-offer-card__title">{{ $offer['title'] }}</h3>
                    <p class="dining-offer-card__text mb-0">{{ $offer['text'] }}</p>
                </article>
            </div>
            @endforeach
        </div>
    </div>
</section>

@if($cuisineCards->isNotEmpty())
<section class="rts__section jarallax restaurant-parallax-hero dining-flavour-band" data-jarallax data-speed="0.5">
    @if($restaurantBgImage)
        <img class="jarallax-img" src="{{ $restaurantBgImage }}" alt="" loading="lazy" decoding="async" width="1920" height="1080">
    @endif
    <div class="dining-flavour-band__shade" aria-hidden="true"></div>
    <div class="container dining-flavour-band__inner">
        <p class="dining-flavour-band__text">{!! $cuisineLeadText !!}</p>
    </div>
</section>

<section class="rts__section section__padding dining-cuisines">
    <div class="container">
        <div class="row justify-content-center text-center mb-40">
            <div class="col-lg-8">
                <p class="page-feature__eyebrow mb-2">Our kitchens</p>
                <h2 class="section__title mb-0">{{ $cuisineSectionTitle }}</h2>
            </div>
        </div>
        <div class="row g-4">
            @foreach($cuisineCards as $cuisine)
                @php
                    $cPath = (string) ($cuisine->image ?? '');
                    $cUrl = $cPath === '' ? '' : (str_contains($cPath, '/') ? asset('storage/'.$cPath) : asset('storage/images/restaurant/cuisines/'.$cPath));
                @endphp
                <div class="col-lg-4 col-md-6">
                    <article class="dining-cuisine-card wow fadeInUp" data-wow-delay="{{ min(0.15 * $loop->iteration, 0.6) }}s">
                        <div class="dining-cuisine-card__media">
                            @if($cUrl)
                                <img src="{{ $cUrl }}" alt="{{ $cuisine->title }}" loading="lazy" width="800" height="600">
                            @else
                                <div class="dining-cuisine-card__fallback" aria-hidden="true"><i class="fa-solid fa-utensils"></i></div>
                            @endif
                            <div class="dining-cuisine-card__overlay" aria-hidden="true"></div>
                            <div class="dining-cuisine-card__body">
                                <h3 class="dining-cuisine-card__name">{{ $cuisine->title }}</h3>
                                @if(filled($cuisine->summary))
                                    <p class="dining-cuisine-card__summary mb-0">{{ $cuisine->summary }}</p>
                                @endif
                            </div>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@php
    $ctaSetting = $setting ?? \App\Models\Setting::first();
@endphp

<section class="home-cta rts__section section__padding" aria-labelledby="page-inquiry-title-dining">
    <div class="container">
        <div class="row g-4 g-xl-4 align-items-stretch">
            <div class="col-lg-6 wow fadeInLeft d-flex">
                @include('frontend.includes.cta-map-panel', ['setting' => $ctaSetting])
            </div>
            <div class="col-lg-6 wow fadeInRight d-flex align-items-stretch">
                @include('frontend.includes.event-inquiry-sidebar', [
                    'formPrefix' => 'dining',
                    'proposalSource' => 'dining',
                    'cardTitle' => 'Plan a meal or catering',
                    'cardLead' => 'Tell us your date, guest count, and whether you need breakfast, an event buffet, or outside catering.',
                    'iconClass' => 'fa-solid fa-utensils',
                ])
            </div>
        </div>
    </div>
</section>

@include('frontend.includes.page-booking-cta')
</div>
