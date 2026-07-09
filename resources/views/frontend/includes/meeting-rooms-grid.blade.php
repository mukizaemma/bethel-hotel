{{--
  Grid of meeting room cards. Expects: $meetingRooms (collection)
  Optional: $excludeSlug — omit that room from the grid (e.g. on detail page)
--}}
@php
    $meetingRooms = $meetingRooms ?? collect();
    $excludeSlug = $excludeSlug ?? null;
    $rooms = $excludeSlug
        ? $meetingRooms->filter(fn ($r) => $r->slug !== $excludeSlug)->values()
        : $meetingRooms;
@endphp
@if($rooms->isNotEmpty())
<div class="row g-4 meeting-rooms-grid">
    @foreach($rooms as $room)
        <div class="col-md-6 col-xl-4">
            <article class="meeting-room-tile card border-0 shadow-sm h-100 overflow-hidden">
                <a wire:navigate href="{{ route('meetings-events.room', $room->slug) }}" class="meeting-room-tile__media-link d-block text-decoration-none">
                    <div class="meeting-room-tile__media ratio ratio-4x3">
                        @if(filled($room->image))
                            <img
                                src="{{ asset('storage/images/meeting-rooms/covers/' . $room->image) }}"
                                alt=""
                                class="meeting-room-tile__img w-100 h-100"
                                loading="lazy"
                            >
                        @else
                            <div class="meeting-room-tile__placeholder d-flex align-items-center justify-content-center h-100 text-muted small">Photo coming soon</div>
                        @endif
                    </div>
                </a>
                <div class="card-body d-flex flex-column">
                    <div class="d-flex flex-wrap align-items-start justify-content-between gap-2 mb-2">
                        <h3 class="h5 mb-0 meeting-room-tile__title">
                            <a wire:navigate href="{{ route('meetings-events.room', $room->slug) }}" class="text-reset text-decoration-none">{{ $room->title }}</a>
                        </h3>
                        <span class="badge rounded-pill meeting-room-tile__badge">Up to {{ $room->max_persons }} guests</span>
                    </div>
                    <p class="meeting-room-tile__excerpt small text-muted flex-grow-1 mb-3">{{ $room->excerpt() }}</p>
                    <a wire:navigate href="{{ route('meetings-events.room', $room->slug) }}" class="btn theme-btn btn-style fill align-self-start meeting-room-tile__btn">
                        View details
                    </a>
                </div>
            </article>
        </div>
    @endforeach
</div>
@endif
