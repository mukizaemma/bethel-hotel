<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Booking.com (primary reservation channel)
    |--------------------------------------------------------------------------
    */

    'booking_com_url' => env('HOTEL_BOOKING_COM_URL', ''),

    /*
    |--------------------------------------------------------------------------
    | TripAdvisor — property on TripAdvisor (locationId for widgets)
    |--------------------------------------------------------------------------
    */

    'tripadvisor_location_id' => env('HOTEL_TRIPADVISOR_LOCATION_ID', ''),

    'tripadvisor_hotel_url' => env('HOTEL_TRIPADVISOR_HOTEL_URL', ''),

    'tripadvisor_write_review_url' => env('HOTEL_TRIPADVISOR_WRITE_REVIEW_URL', ''),

    /*
    |--------------------------------------------------------------------------
    | Google Maps / reviews (place link + optional embed)
    |--------------------------------------------------------------------------
    */

    'google_place_url' => env(
        'HOTEL_GOOGLE_PLACE_URL',
        'https://www.google.com/maps/search/Bethel+Hotel+Rubengera+Karongi+Rwanda'
    ),

    /** Embed without API key (coordinates). */
    'google_maps_embed_url' => env(
        'HOTEL_GOOGLE_MAPS_EMBED_URL',
        'https://maps.google.com/maps?q=Rubengera,Karongi,Rwanda&z=15&output=embed'
    ),

    /*
    |--------------------------------------------------------------------------
    | WhatsApp — digits only, country code, no + (e.g. 250782166233)
    |--------------------------------------------------------------------------
    */

    'whatsapp_e164' => env('HOTEL_WHATSAPP_E164', '250782166233'),

    /** Default first message (URL-encoded automatically when building wa.me links). */
    'whatsapp_default_message' => env(
        'HOTEL_WHATSAPP_MESSAGE',
        'Hello Bethel Hotel, I would like to enquire about:'
    ),

    /*
    |--------------------------------------------------------------------------
    | Public contact email (mailto + displayed)
    |--------------------------------------------------------------------------
    */

    'public_email' => env('HOTEL_PUBLIC_EMAIL', 'centrebethel@ymail.com'),

];
