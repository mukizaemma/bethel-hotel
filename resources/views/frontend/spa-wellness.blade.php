<div class="public-livewire-page">

@php
    $heroImage = '';
    $heroCaption = $pageHero?->caption ?? 'SPA & Wellness';
    $heroDescription = $pageHero?->description
        ?? 'Relaxing massages, therapies and wellness experiences to recharge during your stay.';

    if ($pageHero && $pageHero?->background_image) {
        $heroImage = asset('storage/' . $pageHero?->background_image);
    } elseif ($about && $about?->image2) {
        $heroImage = asset('storage/' . $about?->image2);
    } else {
        $heroImage = asset('storage/images/about/default.jpg');
    }
@endphp

<div class="rts__section page__hero__height page__hero__bg"
     style="background-image: url({{ $heroImage }}); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-12">
                <div class="page__hero__content text-center">
                    <h1 class="wow fadeInUp">{{ $heroCaption }}</h1>
                    <p class="wow fadeInUp font-sm">{{ $heroDescription }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="rts__section section__padding">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-7">
                <h2 class="mb-3">Treatments & Relaxation</h2>
                <p style="line-height: 1.9; color: #555;">
                    Unwind in our SPA & Wellness area with a selection of massages, facials and body treatments.
                    Whether you are looking to relax after a day of activities or enjoy a full wellness retreat,
                    our team will help you feel renewed and refreshed.
                </p>
                <a wire:navigate href="{{ route('contact') }}" class="theme-btn btn-style fill mt-3">
                    <span>Contact Us for Reservations</span>
                </a>
            </div>
            <div class="col-lg-5">
                @if($spaImages->count())
                    <div class="image-gallery-wrapper mb-4">
                        <div class="gallery-main-image">
                            <img id="spaMainImage"
                                 src="{{ asset('storage/' . $spaImages->first()->image) }}"
                                 alt="SPA & Wellness"
                                 class="gallery-main-img">
                        </div>
                        @if($spaImages->count() > 1)
                            <div class="gallery-thumbnails">
                                @foreach($spaImages as $index => $img)
                                    <div class="thumbnail-item {{ $index === 0 ? 'active' : '' }}"
                                         data-image="{{ asset('storage/' . $img->image) }}">
                                        <img src="{{ asset('storage/' . $img->image) }}"
                                             alt="SPA image"
                                             class="thumbnail-img">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const mainImage = document.getElementById('spaMainImage');
    const thumbnails = document.querySelectorAll('.gallery-thumbnails .thumbnail-item');

    if (mainImage && thumbnails.length > 0) {
        thumbnails.forEach(thumbnail => {
            thumbnail.addEventListener('click', function () {
                const newImageSrc = this.getAttribute('data-image');
                thumbnails.forEach(thumb => thumb.classList.remove('active'));
                this.classList.add('active');
                mainImage.style.opacity = '0';
                setTimeout(() => {
                    mainImage.src = newImageSrc;
                    mainImage.style.opacity = '1';
                }, 200);
            });
        });
    }
});
</script>


@include('frontend.includes.page-booking-cta')
</div>
