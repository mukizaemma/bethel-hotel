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
        Schema::create('room_movements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
            $table->unsignedBigInteger('from_room_id');
            $table->foreign('from_room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->unsignedBigInteger('to_room_id');
            $table->foreign('to_room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->text('reason')->nullable();
            $table->unsignedBigInteger('moved_by');
            $table->foreign('moved_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_movements');
    }
};
