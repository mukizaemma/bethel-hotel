<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('page_heroes')) {
            Schema::create('page_heroes', function (Blueprint $table) {
                $table->id();
                $table->string('page_slug')->unique(); // about, terms, contact, rooms, facilities, updates, gallery, book-now
                $table->string('page_name'); // Display name for admin
                $table->string('background_image')->nullable();
                $table->string('caption')->nullable(); // Hero section caption/text
                $table->text('description')->nullable(); // Optional description
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_heroes');
    }
};
