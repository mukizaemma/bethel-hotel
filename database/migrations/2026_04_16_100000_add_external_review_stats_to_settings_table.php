<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->decimal('booking_com_review_score', 3, 1)->nullable()->after('booking_com_url');
            $table->unsignedInteger('booking_com_review_count')->nullable()->after('booking_com_review_score');
            $table->text('booking_com_review_summary')->nullable()->after('booking_com_review_count');
            $table->text('booking_com_write_review_url')->nullable()->after('booking_com_review_summary');

            $table->decimal('tripadvisor_review_score', 2, 1)->nullable()->after('tripadvisor_write_review_url');
            $table->unsignedInteger('tripadvisor_review_count')->nullable()->after('tripadvisor_review_score');
            $table->text('tripadvisor_review_summary')->nullable()->after('tripadvisor_review_count');

            $table->decimal('google_review_score', 2, 1)->nullable()->after('google_maps_embed_url');
            $table->unsignedInteger('google_review_count')->nullable()->after('google_review_score');
            $table->text('google_review_summary')->nullable()->after('google_review_count');
            $table->text('google_write_review_url')->nullable()->after('google_review_summary');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'booking_com_review_score',
                'booking_com_review_count',
                'booking_com_review_summary',
                'booking_com_write_review_url',
                'tripadvisor_review_score',
                'tripadvisor_review_count',
                'tripadvisor_review_summary',
                'google_review_score',
                'google_review_count',
                'google_review_summary',
                'google_write_review_url',
            ]);
        });
    }
};
