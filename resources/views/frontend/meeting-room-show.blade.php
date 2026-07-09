<div class="public-livewire-page">

@include('frontend.includes.page-hero-banner', [
    'defaultCaption' => $room->title,
    'defaultDescription' => 'Up to '.$room->max_persons.' guests · Meetings & events',
])

<section class="meeting-room-detail rts__section section__padding pt-4">
    <div class="container">
        <nav class="meeting-room-detail__breadcrumb small text-muted mb-4" aria-label="Breadcrumb">
            <a wire:navigate href="{{ route('home') }}">Home</a>
            <span class="mx-1">/</span>
            <a wire:navigate href="{{ route('meetings-events') }}">Meetings &amp; Events</a>
            <span class="mx-1">/</span>
            <span class="text-body">{{ $room->title }}</span>
        </nav>

        <div class="meeting-room-detail__intro page-feature__prose content-richtext mb-5 mb-lg-5 w-100">
            @if(filled($room->description))
                {!! $room->description !!}
            @else
                <p class="text-muted mb-0">Description for this room can be added in the admin.</p>
            @endif
        </div>

        <div class="row g-4 g-lg-4 meeting-room-detail__split align-items-start">
            <div class="col-12 meeting-room-detail__gallery-wrap">
                @if($room->images && $room->images->isNotEmpty())
                    @include('frontend.includes.page-gallery', [
                        'galleryImages' => $room->images,
                        'storageSubfolder' => 'meeting-rooms/gallery',
                        'galleryKey' => 'meetings-room-'.$room->id,
                    ])
                @else
                    <div class="page-gallery-root page-gallery-root--empty rounded-4 d-flex align-items-center justify-content-center mb-0" style="min-height: 200px;">
                        <p class="text-muted mb-0 small">No gallery images for this room yet.</p>
                    </div>
                @endif
            </div>
            <div class="col-12 meeting-room-detail__form-wrap">
                @include('frontend.includes.event-inquiry-sidebar', [
                    'formPrefix' => 'meetings-room-'.$room->id,
                    'proposalSource' => 'meetings',
                    'cardTitle' => 'Request a proposal',
                    'cardLead' => 'Planning an event in this space? Tell us your date and guest count.',
                    'iconClass' => 'fa-solid fa-building-columns',
                    'meetingRoomLabel' => $room->title,
                ])
            </div>
        </div>

        @if($otherMeetingRooms->isNotEmpty())
            <div class="meeting-room-detail__others mt-5 pt-5 border-top">
                <h2 class="h4 mb-4">Other meeting rooms</h2>
                @include('frontend.includes.meeting-rooms-grid', [
                    'meetingRooms' => $otherMeetingRooms,
                    'excludeSlug' => null,
                ])
            </div>
        @endif

        <p class="mt-4 mb-0 text-center">
            <a wire:navigate href="{{ route('meetings-events') }}" class="btn btn-outline-secondary btn-sm">← Back to Meetings &amp; Events</a>
        </p>
    </div>
</section>

@include('frontend.includes.page-booking-cta')
</div>
