<div class="public-livewire-page">

@php
    $heroImage = '';
    $heroCaption = 'Tour Activities';
    $heroDescription = 'Discover unforgettable experiences and adventures tailored for every traveler.';

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

    <div class="rts__section section__padding">
        <div class="container">
            <div class="row g-4">
                @forelse ($activities as $activity)
                    @php
                        $coverUrl = $activity->cover_image
                            ? asset('storage/' . $activity->cover_image)
                            : asset('storage/images/about/default.jpg');
                    @endphp
                    <div class="col-lg-4 col-md-6">
                        <div class="h-100 d-flex flex-column rounded-3 overflow-hidden shadow-sm border" style="background: #fff; border-color: #eee !important;">
                            <div class="flex-grow-0">
                                <a wire:navigate href="{{ route('activity', ['slug' => $activity->slug]) }}">
                                    <img src="{{ $coverUrl }}" alt="{{ $activity->title }}" loading="lazy" style="width: 100%; height: 260px; object-fit: cover;">
                                </a>
                            </div>
                            <div class="p-4 d-flex flex-column flex-grow-1">
                                <a wire:navigate href="{{ route('activity', ['slug' => $activity->slug]) }}" class="h5 mb-2 text-dark text-decoration-none">{{ $activity->title }}</a>
                                <div class="flex-grow-1 mb-3">
                                    <p class="font-sm text-muted mb-0">{!! Str::words(strip_tags($activity->description ?? ''), 22, '...') !!}</p>
                                </div>
                                <a wire:navigate href="{{ route('activity', ['slug' => $activity->slug]) }}" class="theme-btn btn-style fill align-self-start">
                                    <span>View more</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted mb-0">No tour activities available yet.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

@include('frontend.includes.page-booking-cta')
</div>
