<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->unsignedInteger('guests_included_in_price')->default(2)->after('couplePrice');
            $table->unsignedBigInteger('extra_adult_price')->nullable()->after('guests_included_in_price');
            $table->unsignedBigInteger('extra_child_price')->nullable()->after('extra_adult_price');
            $table->unsignedBigInteger('extra_bed_price')->nullable()->after('extra_child_price');
        });
    }

    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn([
                'guests_included_in_price',
                'extra_adult_price',
                'extra_child_price',
                'extra_bed_price',
            ]);
        });
    }
};
