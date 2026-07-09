<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->string('cuisine_section_title')->nullable()->after('image');
            $table->text('cuisine_section_lead')->nullable()->after('cuisine_section_title');
        });

        Schema::create('restaurant_cuisines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained('restaurants')->cascadeOnDelete();
            $table->string('title');
            $table->string('summary')->nullable();
            $table->string('image')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('restaurant_cuisines');

        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropColumn(['cuisine_section_title', 'cuisine_section_lead']);
        });
    }
};
