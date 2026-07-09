<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meeting_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('eventpage_id')->constrained('eventpages')->cascadeOnDelete();
            $table->string('title');
            $table->unsignedInteger('max_persons')->default(0);
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('meeting_room_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meeting_room_id')->constrained('meeting_rooms')->cascadeOnDelete();
            $table->string('image');
            $table->string('caption')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        $eventpageId = DB::table('eventpages')->orderBy('id')->value('id');
        if ($eventpageId) {
            $now = now();
            $defaults = [
                ['title' => 'Salle Kibeho', 'max_persons' => 50, 'sort_order' => 1],
                ['title' => 'Salle Lourde', 'max_persons' => 250, 'sort_order' => 2],
                ['title' => 'Salle no 111', 'max_persons' => 15, 'sort_order' => 3],
            ];
            foreach ($defaults as $row) {
                DB::table('meeting_rooms')->insert([
                    'eventpage_id' => $eventpageId,
                    'title' => $row['title'],
                    'max_persons' => $row['max_persons'],
                    'description' => null,
                    'image' => null,
                    'sort_order' => $row['sort_order'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('meeting_room_images');
        Schema::dropIfExists('meeting_rooms');
    }
};
