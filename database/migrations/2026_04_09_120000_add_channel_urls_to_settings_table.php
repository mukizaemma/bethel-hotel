<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->text('booking_com_url')->nullable();
            $table->string('tripadvisor_location_id', 32)->nullable();
            $table->text('tripadvisor_hotel_url')->nullable();
            $table->text('tripadvisor_write_review_url')->nullable();
            $table->text('google_place_url')->nullable();
            $table->text('google_maps_embed_url')->nullable();
            $table->string('whatsapp_e164', 32)->nullable();
            $table->text('whatsapp_default_message')->nullable();
            $table->string('channel_contact_email')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'booking_com_url',
                'tripadvisor_location_id',
                'tripadvisor_hotel_url',
                'tripadvisor_write_review_url',
                'google_place_url',
                'google_maps_embed_url',
                'whatsapp_e164',
                'whatsapp_default_message',
                'channel_contact_email',
            ]);
        });
    }
};
