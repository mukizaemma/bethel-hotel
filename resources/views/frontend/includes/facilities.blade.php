{{-- Full facilities listing — matches home "Our Services" / home-room-card layout --}}
<div class="rts__section section__padding home-services-section pb-120" style="background: #f5f6f8;">
    <div class="container">
        <div class="row g-4 g-lg-4 justify-content-center">
            @forelse ($facilities as $facility)
            <div class="col-12 col-md-6">
                <article class="home-room-card">
                    <a wire:navigate href="{{ route('facility', ['slug' => $facility->slug]) }}" class="home-room-card__media">
                        <img src="{{ asset('storage/' . ($facility->cover_image ?? 'facilities/default.jpg')) }}"
                            alt="{{ $facility->title }}"
                            loading="lazy"
                            width="800"
                            height="480">
                    </a>
                    <div class="home-room-card__body">
                        <div class="home-room-card__head home-room-card__head--title-only">
                            <a wire:navigate href="{{ route('facility', ['slug' => $facility->slug]) }}" class="home-room-card__title">{{ $facility->title }}</a>
                        </div>
                        <p class="home-room-card__excerpt">
                            {!! Str::words(strip_tags($facility->description ?? ''), 28, '…') !!}
                        </p>
                        <div class="home-room-card__actions">
                            <a wire:navigate href="{{ route('facility', ['slug' => $facility->slug]) }}" class="theme-btn btn-style sm-btn border">
                                <span>View details</span>
                            </a>
                            <a wire:navigate href="{{ route('contact') }}" class="theme-btn btn-style sm-btn fill">
                                <span>Contact us</span>
                            </a>
                        </div>
                    </div>
                </article>
            </div>
            @empty
            <div class="col-12 text-center py-5 text-muted">
                <p class="mb-0">No services available at the moment.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
