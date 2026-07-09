<div class="public-livewire-page">

@php
    $heroImage = '';
    $heroCaption = 'Hotel Rooms';
    $heroDescription = 'Comfortable rooms for short and longer stays at Bethel Hotel.';
    if ($pageHero && !empty($pageHero->background_image)) {
        $heroImage = asset('storage/' . $pageHero->background_image);
        $heroCaption = $pageHero->caption ?? $heroCaption;
        $heroDescription = $pageHero->description ?? $heroDescription;
    } elseif ($about && $about?->image2) {
        if (strpos($about?->image2, '/') !== false || strpos($about?->image2, 'abouts') === 0) {
            $heroImage = asset('storage/' . $about?->image2);
        } else {
            $heroImage = asset('storage/images/about/' . $about?->image2);
        }
    } else {
        $heroImage = asset('storage/images/about/default.jpg');
    }
@endphp

<!-- Page header -->
<div class="rts__section page__hero__height page__hero__bg" style="background-image: url({{ $heroImage }}); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-12">
                <div class="page__hero__content">
                    <h1 class="wow fadeInUp">{{ $heroCaption }}</h1>
                    <p class="wow fadeInUp font-sm">{{ $heroDescription }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="rts__section section__padding pt-50 pb-120">
    <div class="container">
        <div class="row g-4">
            @forelse($rooms as $room)
            <div class="col-lg-4 col-md-6">
                <div class="room__card h-100 d-flex flex-column rounded-3 overflow-hidden shadow-sm" style="background: #fff; border: 1px solid #eee;">
                    <div class="room__card__top flex-grow-0">
                        <div class="room__card__image">
                            <a wire:navigate href="{{ route('room', ['slug' => $room->slug]) }}">
                                <img src="{{ asset('storage/' . ($room->cover_image ?? 'rooms/default.jpg')) }}" width="420" height="280" alt="{{ $room->title ?? 'Room' }}" loading="lazy" style="width: 100%; height: 280px; object-fit: cover;">
                            </a>
                        </div>
                    </div>
                    <div class="room__card__meta p-4 d-flex flex-column flex-grow-1">
                        <a wire:navigate href="{{ route('room', ['slug' => $room->slug]) }}" class="room__card__title h5 mb-2 text-dark text-decoration-none">{{ $room->title }}</a>
                        <div class="room__price__tag mb-2">
                            <span class="h5 text-primary">{{ hotel_price($room->price ?? 0, $setting) }}/Night</span>
                        </div>
                        <div class="room__card__meta__info mb-3 flex-grow-1">
                            <p class="font-sm text-muted mb-0">{!! Str::words(strip_tags($room->description ?? ''), 20, '...') !!}</p>
                        </div>
                        <a wire:navigate href="{{ route('room', ['slug' => $room->slug]) }}#booking" class="theme-btn btn-style fill align-self-start">
                            <span>View details &amp; Book</span>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5 text-muted">
                <p class="mb-0">No rooms available at the moment.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

@include('frontend.includes.page-booking-cta')
</div>
