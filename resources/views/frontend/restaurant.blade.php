<div class="public-livewire-page">

@include('frontend.includes.page-hero-banner', [
    'defaultCaption' => $restaurant->title ?? 'Dining',
    'defaultDescription' => 'Discover our restaurant, bar, and garden dining experiences.',
])

@php
    $galleryImages = $images ?? collect();
    $cuisineCards = isset($cuisines) ? $cuisines->filter(fn ($c) => filled($c->image)) : collect();
    $cuisineSectionTitle = filled($restaurant->cuisine_section_title ?? null)
        ? $restaurant->cuisine_section_title
        : 'Culinary specializations';
@endphp

@php
    $restaurantBgImage = filled($restaurant->image ?? null)
        ? asset('storage/images/restaurant/' . $restaurant->image)
        : (filled($images?->first()?->image) ? asset('storage/images/restaurant/' . $images->first()->image) : null);

    $cuisineLeadText = filled($restaurant->cuisine_section_lead ?? null)
        ? $restaurant->cuisine_section_lead
        : 'You don\'t have to choose just one style. Our chefs prepare authentic dishes from three of the world\'s best cuisines';
@endphp

<section class="page-feature rts__section section__padding">
    <div class="container">
        <div class="row g-4 g-xl-5 align-items-start">
            <div class="col-12">
                <div class="d-flex flex-wrap flex-lg-nowrap gap-4 align-items-start justify-content-between restaurant-title-gallery">
                    <div class="restaurant-title-col" style="flex: 0 0 40%; max-width: 40%;">
                        <header class="page-feature__header mb-4 mb-lg-0">
                            <p class="page-feature__eyebrow">Dining &amp; bar</p>
                            <h2 class="page-feature__title section__title">{{ $restaurant->title ?? 'Our restaurant' }}</h2>
                            <p class="page-feature__subtitle font-sm mb-0">
                                Fresh flavors, warm service, and a setting designed for relaxed meals and celebrations.
                            </p>
                        </header>
                    </div>

                    <div class="restaurant-gallery-col" style="flex: 0 0 60%; max-width: 60%;">
                        @include('frontend.includes.page-gallery', [
                            'galleryImages' => $galleryImages,
                            'storageSubfolder' => 'restaurant',
                            'galleryKey' => 'dining',
                        ])
                    </div>
                </div>
            </div>
        </div>

        @if($cuisineCards->isNotEmpty())
            <style>
                @media (max-width: 991.98px) {
                    .restaurant-title-col,
                    .restaurant-gallery-col {
                        flex: 0 0 100% !important;
                        max-width: 100% !important;
                    }
                }
            </style>

            <section
                class="rts__section jarallax restaurant-parallax-hero"
                style="
                    width: 100vw;
                    margin-left: calc(50% - 50vw);
                    margin-right: calc(50% - 50vw);
                    min-height: 80vh;
                    display: flex;
                    align-items: center;
                    margin-top: 40px;
                    position: relative;
                    overflow: hidden;
                    background: #0b1220;
                "
                data-jarallax
                data-speed="0.5"
            >
                @if($restaurantBgImage)
                    <img class="jarallax-img" src="{{ $restaurantBgImage }}" alt="" loading="lazy" decoding="async" width="1920" height="1080">
                @endif

                <div style="position: absolute; inset: 0; background: linear-gradient(180deg, rgba(2,6,23,0.35) 0%, rgba(2,6,23,0.55) 55%, rgba(2,6,23,0.35) 100%);"></div>

                <div class="container" style="position: relative; z-index: 1;">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <p class="mb-0 text-center" style="color: #fff; font-size: clamp(1.6rem, 2.9vw, 2.6rem); font-weight: 650; line-height: 1.55; text-shadow: 0 8px 24px rgba(0,0,0,0.35);">
                                {!! $cuisineLeadText !!}
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="rts__section section__padding">
                <div class="container">
                    <div class="row justify-content-center text-center mb-40">
                        <div class="col-lg-12">
                            <p class="page-feature__eyebrow mb-2">Our kitchens</p>
                            <h2 class="section__title mb-0">{{ $cuisineSectionTitle }}</h2>
                        </div>
                    </div>

                    <div class="row g-4">
                        @foreach($cuisineCards as $cuisine)
                            <div class="col-lg-4 col-md-6">
                                <article class="dining-cuisine-card wow fadeInUp" data-wow-delay="{{ min(0.15 * $loop->iteration, 0.6) }}s">
                                    <div class="dining-cuisine-card__media">
                                        <img
                                            src="{{ asset('storage/images/restaurant/cuisines/' . $cuisine->image) }}"
                                            alt="{{ $cuisine->title }}"
                                            loading="lazy"
                                            width="800"
                                            height="600"
                                        >
                                        <div class="dining-cuisine-card__overlay" aria-hidden="true"></div>
                                        <div class="dining-cuisine-card__body">
                                            <h3 class="dining-cuisine-card__name">{{ $cuisine->title }}</h3>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    </div>
</section>

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
                    'cardTitle' => 'Request a proposal',
                    'cardLead' => 'Share your date, guest count, and event type — our team will follow up with options.',
                    'iconClass' => 'fa-solid fa-utensils',
                ])
            </div>
        </div>
    </div>
</section>

@include('frontend.includes.page-booking-cta')
</div>
