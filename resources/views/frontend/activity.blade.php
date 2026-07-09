<div class="public-livewire-page">

@php
    $heroImage = $activity->cover_image
        ? asset('storage/' . $activity->cover_image)
        : (($about && $about?->image2) ? asset('storage/' . $about?->image2) : asset('storage/images/about/default.jpg'));
@endphp

    <!-- Page header: cover image -->
    <div class="rts__section page__hero__height page__hero__bg" style="background-image: url({{ $heroImage }}); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-12">
                    <div class="page__hero__content">
                        <h1 class="wow fadeInUp">{{ $activity->title }}</h1>
                        <p class="wow fadeInUp font-sm">Book your spot for this experience</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Description -->
    <div class="rts__section section__padding" style="background: #fff;">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="mb-0">
                        {!! $activity->description !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gallery -->
    @if($images->isNotEmpty())
    <div class="rts__section section__padding" style="background: #f9f9f9;">
        <div class="container">
            <div class="row justify-content-center text-center mb-4">
                <div class="col-lg-6">
                    <h2 class="mb-0" style="font-size: 28px; font-weight: bold;">Gallery</h2>
                </div>
            </div>
            <div class="row g-4">
                @foreach($images as $img)
                    @php
                        $imgUrl = $img->image && (strpos($img->image, 'tour-activities/') === 0 || strpos($img->image, '/') !== false)
                            ? asset('storage/' . $img->image)
                            : asset('storage/images/tour-activities/' . $img->image);
                    @endphp
                    <div class="col-lg-4 col-md-6">
                        <div class="rounded-3 overflow-hidden shadow-sm bg-white">
                            <img src="{{ $imgUrl }}" alt="{{ $img->caption ?? $activity->title }}" loading="lazy" style="width: 100%; height: 260px; object-fit: cover;">
                            @if(!empty($img->caption))
                                <p class="p-3 mb-0 small text-muted">{{ $img->caption }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Booking form for this tour activity -->
    <div class="rts__section section__padding" id="booking">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="rts__booking__form has__background" style="padding: 40px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                        <h3 class="mb-20 text-center">Book or enquire</h3>
                        <p class="text-muted small text-center mb-4">
                            Room nights: <strong>Booking.com</strong>. For this activity, contact us on WhatsApp or email.
                        </p>
                        @include('frontend.includes.hotel-booking-channels', ['contextLabel' => ' Activity: '.$activity->title])
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Other activities -->
    @if($allActivities->isNotEmpty())
    <div class="rts__section section__padding" style="background: #f9f9f9;">
        <div class="container">
            <div class="row justify-content-center text-center mb-4">
                <div class="col-lg-6">
                    <h2 class="mb-0" style="font-size: 28px; font-weight: bold;">Other Tour Activities</h2>
                </div>
            </div>
            <div class="row g-4">
                @foreach($allActivities as $other)
                    @php
                        $otherCover = $other->cover_image ? asset('storage/' . $other->cover_image) : asset('storage/images/about/default.jpg');
                    @endphp
                    <div class="col-lg-4 col-md-6">
                        <div class="h-100 rounded-3 overflow-hidden shadow-sm bg-white">
                            <a wire:navigate href="{{ route('activity', ['slug' => $other->slug]) }}">
                                <img src="{{ $otherCover }}" alt="{{ $other->title }}" loading="lazy" style="width: 100%; height: 220px; object-fit: cover;">
                            </a>
                            <div class="p-3">
                                <a wire:navigate href="{{ route('activity', ['slug' => $other->slug]) }}" class="h6 text-dark text-decoration-none">{{ $other->title }}</a>
                                <a wire:navigate href="{{ route('activity', ['slug' => $other->slug]) }}" class="d-block mt-2 small text-primary">View more</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

@include('frontend.includes.page-booking-cta')
</div>
