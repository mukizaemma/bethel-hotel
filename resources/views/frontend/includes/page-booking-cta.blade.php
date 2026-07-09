@php
    $ctaRooms = $rooms ?? \App\Models\Room::where('status', 'Active')->oldest()->get();
    $ctaHeadingId = $headingId ?? 'page-booking-cta';
@endphp
<x-booking-cta
    :rooms="$ctaRooms"
    :heading-id="$ctaHeadingId"
    :show-children-field="true"
/>
