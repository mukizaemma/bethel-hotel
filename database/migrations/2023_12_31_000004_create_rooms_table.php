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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('room_number')->unique()->nullable();
            $table->string('category')->nullable();
            $table->string('room_type')->default('room');
            $table->string('image')->nullable();
            $table->string('cover_image')->nullable();
            $table->longText('description')->nullable();
            $table->unsignedBigInteger('price')->nullable();
            $table->unsignedBigInteger('couplePrice')->nullable();
            $table->integer('max_occupancy')->default(2);
            $table->integer('bed_count')->default(1);
            $table->string('bed_type')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->enum('room_status', ['available', 'occupied', 'reserved', 'maintenance'])->default('available');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
