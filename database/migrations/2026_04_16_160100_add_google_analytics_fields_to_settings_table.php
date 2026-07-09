<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('ga4_measurement_id', 32)->nullable()->after('channel_contact_email');
            $table->text('ga4_reports_url')->nullable()->after('ga4_measurement_id');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['ga4_measurement_id', 'ga4_reports_url']);
        });
    }
};
