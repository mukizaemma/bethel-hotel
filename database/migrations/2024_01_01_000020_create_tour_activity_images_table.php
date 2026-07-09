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
        Schema::create('tour_activity_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tour_activity_id');
            $table->foreign('tour_activity_id')->references('id')->on('tour_activities')->onDelete('cascade');
            $table->string('image');
            $table->string('caption')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_activity_images');
    }
};
