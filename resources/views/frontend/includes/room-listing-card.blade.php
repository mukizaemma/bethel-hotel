{{-- Matches home "Our Hotel Rooms" cards — expects $room (Room model) --}}
<div class="col-12 col-md-6">
    <article class="home-room-card">
        <a wire:navigate href="{{ route('room', ['slug' => $room->slug]) }}" class="home-room-card__media">
            <img src="{{ asset('storage/' . ($room->cover_image ?? 'rooms/default.jpg')) }}"
                alt="{{ $room->title }}"
                loading="lazy"
                width="800"
                height="480">
        </a>
        <div class="home-room-card__body">
            <div class="home-room-card__head">
                <a wire:navigate href="{{ route('room', ['slug' => $room->slug]) }}" class="home-room-card__title">{{ $room->title }}</a>
                <div class="home-room-card__price">
                    <span class="home-room-card__price-from">Starts from</span>
                    <div class="home-room-card__price-line">
                        <span class="home-room-card__price-amount">{{ hotel_price($room->price ?? 0, $setting) }}</span>
                        <span class="home-room-card__price-unit">/ night</span>
                    </div>
                </div>
            </div>
            <p class="home-room-card__excerpt">
                {!! Str::words(strip_tags($room->description ?? ''), 28, '…') !!}
            </p>
            <div class="home-room-card__actions">
                <a wire:navigate href="{{ route('room', ['slug' => $room->slug]) }}" class="theme-btn btn-style sm-btn border">
                    <span>View Details</span>
                </a>
                <a wire:navigate href="{{ route('room', ['slug' => $room->slug]) }}#booking" class="theme-btn btn-style sm-btn fill">
                    <span>Book Now</span>
                </a>
            </div>
        </div>
    </article>
</div>
