<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->boolean('footer_delivered_by_enabled')->default(true)->after('deliveryInfo');
            $table->string('footer_delivered_by_company', 255)->nullable()->after('footer_delivered_by_enabled');
            $table->string('footer_delivered_by_url', 500)->nullable()->after('footer_delivered_by_company');
        });

        DB::table('settings')->update([
            'footer_delivered_by_company' => 'Ireme Technologies',
            'footer_delivered_by_url' => 'https://iremetech.com',
            'footer_delivered_by_enabled' => true,
        ]);
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'footer_delivered_by_enabled',
                'footer_delivered_by_company',
                'footer_delivered_by_url',
            ]);
        });
    }
};
