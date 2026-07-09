<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('meeting_rooms', function (Blueprint $table) {
            $table->string('slug', 191)->nullable()->after('title');
            $table->text('summary')->nullable()->after('description');
        });

        $rows = DB::table('meeting_rooms')->orderBy('id')->get();
        foreach ($rows as $row) {
            $slug = Str::slug($row->title ?? 'room-'.$row->id);
            $base = $slug;
            $n = 1;
            while (
                DB::table('meeting_rooms')
                    ->where('eventpage_id', $row->eventpage_id)
                    ->where('slug', $slug)
                    ->where('id', '!=', $row->id)
                    ->exists()
            ) {
                $slug = $base.'-'.$n++;
            }
            DB::table('meeting_rooms')->where('id', $row->id)->update(['slug' => $slug]);
        }

        Schema::table('meeting_rooms', function (Blueprint $table) {
            $table->unique(['eventpage_id', 'slug'], 'meeting_rooms_eventpage_slug_unique');
        });
    }

    public function down(): void
    {
        Schema::table('meeting_rooms', function (Blueprint $table) {
            $table->dropUnique('meeting_rooms_eventpage_slug_unique');
            $table->dropColumn(['slug', 'summary']);
        });
    }
};
