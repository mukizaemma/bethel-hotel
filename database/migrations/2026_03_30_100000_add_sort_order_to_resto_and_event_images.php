<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('restoimages', function (Blueprint $table) {
            $table->unsignedInteger('sort_order')->default(0)->after('caption');
        });
        Schema::table('eventimages', function (Blueprint $table) {
            $table->unsignedInteger('sort_order')->default(0)->after('caption');
        });

        $i = 0;
        foreach (DB::table('restoimages')->orderBy('id')->pluck('id') as $id) {
            DB::table('restoimages')->where('id', $id)->update(['sort_order' => $i++]);
        }
        $i = 0;
        foreach (DB::table('eventimages')->orderBy('id')->pluck('id') as $id) {
            DB::table('eventimages')->where('id', $id)->update(['sort_order' => $i++]);
        }
    }

    public function down(): void
    {
        Schema::table('restoimages', function (Blueprint $table) {
            $table->dropColumn('sort_order');
        });
        Schema::table('eventimages', function (Blueprint $table) {
            $table->dropColumn('sort_order');
        });
    }
};
