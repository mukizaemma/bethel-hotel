<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $table ='settings';    

    protected $fillable =[
        'company',
        'address',
        'email',
        'phone',
        'reception_phone',
        'manager_phone',
        'restaurant_phone',
        'logo',
        'deliveryInfo',
        'footer_delivered_by_enabled',
        'footer_delivered_by_company',
        'footer_delivered_by_url',
        'facebook',
        'twitter',
        'instagram',
        'youtube',
        'linkedin',
        'linktree',
        'quote',
        'google_map_embed',
        'star_rating',
        'booking_com_url',
        'booking_com_review_score',
        'booking_com_review_count',
        'booking_com_review_summary',
        'booking_com_write_review_url',
        'tripadvisor_location_id',
        'tripadvisor_hotel_url',
        'tripadvisor_write_review_url',
        'tripadvisor_review_score',
        'tripadvisor_review_count',
        'tripadvisor_review_summary',
        'google_place_url',
        'google_maps_embed_url',
        'google_review_score',
        'google_review_count',
        'google_review_summary',
        'google_write_review_url',
        'whatsapp_e164',
        'whatsapp_default_message',
        'channel_contact_email',
        'ga4_measurement_id',
        'ga4_reports_url',
        'price_currency',
    ];

    protected $casts = [
        'star_rating' => 'integer',
        'footer_delivered_by_enabled' => 'boolean',
        'booking_com_review_score' => 'decimal:1',
        'booking_com_review_count' => 'integer',
        'tripadvisor_review_score' => 'decimal:1',
        'tripadvisor_review_count' => 'integer',
        'google_review_score' => 'decimal:1',
        'google_review_count' => 'integer',
        'price_currency' => 'string',
    ];
}
