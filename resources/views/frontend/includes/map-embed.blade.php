@php
    $setting = $setting ?? \App\Models\Setting::first();
    $hc = \App\Models\HotelContact::first();
    $channels = \App\Support\HotelChannels::all();
    $embedRaw = trim((string) (
        $setting?->google_map_embed
        ?? $setting?->google_maps_embed_url
        ?? $channels['google_maps_embed_url']
        ?? ''
    ));
    $mapSrc = null;
    $mapHtml = null;

    if ($embedRaw !== '') {
        if (str_contains(strtolower($embedRaw), '<iframe')) {
            $mapHtml = $embedRaw;
        } elseif (filter_var($embedRaw, FILTER_VALIDATE_URL)) {
            $mapSrc = $embedRaw;
        }
    }

    if ($mapSrc === null && $hc?->latitude && $hc?->longitude) {
        $mapSrc = 'https://maps.google.com/maps?q='.$hc->latitude.','.$hc->longitude.'&z=15&output=embed';
    }
@endphp
@if($mapHtml)
    {!! $mapHtml !!}
@elseif($mapSrc)
    <iframe
        title="Hotel location on Google Maps"
        src="{{ $mapSrc }}"
        width="100%"
        height="100%"
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
        allowfullscreen=""
    ></iframe>
@else
    <div class="map-embed__placeholder text-muted small p-4 text-center">Map location will appear here.</div>
@endif
