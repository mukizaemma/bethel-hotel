<div class="public-livewire-page">

@include('frontend.includes.page-hero-banner', [
    'defaultCaption' => $event->title ?? 'Meetings & Events',
    'defaultDescription' => $pageHero?->description ?? 'Host your meetings, celebrations, and conferences with us.',
])

@php
    $meetingRooms = $meetingRooms ?? collect();
@endphp

<section class="page-feature page-feature--meetings rts__section section__padding">
    <div class="container meetings-events-intro">
        <header class="page-feature__header mb-4 mb-lg-5 text-center text-lg-start">
            <p class="page-feature__eyebrow">Meetings &amp; events</p>
            <h2 class="page-feature__title section__title">{{ $event->title ?? 'Meetings & Events' }}</h2>
            <p class="page-feature__subtitle font-sm mx-auto ms-lg-0">
                Flexible spaces and attentive support for workshops, seminars, and meetings in Rubengera.
            </p>
        </header>

        <div class="page-feature__prose content-richtext meetings-events-intro__description mb-4 mb-lg-5 w-100">
            @if(filled($event->description))
                {!! $event->description !!}
            @else
                <p class="text-muted mb-0">Event information will appear here once added in the admin.</p>
            @endif
        </div>

        @if(filled($event->details ?? null))
            <div class="page-feature__details mt-5 pt-4 border-top w-100">
                <h2 class="h5 mb-3">Details &amp; logistics</h2>
                <div class="page-feature__prose content-richtext mb-0">
                    {!! $event->details !!}
                </div>
            </div>
        @endif
    </div>
</section>

@if($meetingRooms->isNotEmpty())
<section class="meetings-events-rooms rts__section section__padding pt-0">
    <div class="container">
        <h2 class="h3 mb-4 mb-lg-5">Our meeting rooms</h2>
        @include('frontend.includes.meeting-rooms-grid', ['meetingRooms' => $meetingRooms])
    </div>
</section>
@endif

<section class="meetings-events-proposal rts__section section__padding pt-0 pb-5">
    <div class="container">
        @if(isset($whyChooseUsItems) && $whyChooseUsItems->isNotEmpty())
            <div class="row align-items-stretch g-4 g-lg-5 meetings-events-wcu-row">
                <div class="col-12 meetings-events-wcu-col meetings-events-wcu-col--why">
                    @include('layouts.includes.why-choose-us', ['whyChooseUsLayout' => 'meetings'])
                </div>
                <div class="col-12 meetings-events-wcu-col meetings-events-wcu-col--form">
                    @include('frontend.includes.event-inquiry-sidebar', [
                        'formPrefix' => 'meetings',
                        'proposalSource' => 'meetings',
                        'cardTitle' => 'Request a proposal',
                        'cardLead' => 'Share your date, guest count, and event type — our team will follow up with options.',
                        'iconClass' => 'fa-solid fa-building-columns',
                    ])
                </div>
            </div>
        @else
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-7">
                    @include('frontend.includes.event-inquiry-sidebar', [
                        'formPrefix' => 'meetings',
                        'proposalSource' => 'meetings',
                        'cardTitle' => 'Request a proposal',
                        'cardLead' => 'Share your date, guest count, and event type — our team will follow up with options.',
                        'iconClass' => 'fa-solid fa-building-columns',
                    ])
                </div>
            </div>
        @endif
    </div>
</section>

@include('frontend.includes.page-booking-cta')
</div>
