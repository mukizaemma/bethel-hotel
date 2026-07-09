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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('names');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('checkin')->nullable();
            $table->string('checkout')->nullable();
            $table->date('checkin_date')->nullable();
            $table->date('checkout_date')->nullable();
            $table->integer('adults')->nullable();
            $table->integer('children')->nullable();
            $table->integer('rooms')->nullable();
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->decimal('balance_amount', 10, 2)->default(0);
            $table->enum('payment_status', ['pending', 'partial', 'paid', 'refunded'])->default('pending');
            $table->enum('booking_type', ['online', 'walkin'])->default('online');
            $table->text('others')->nullable();
            $table->text('admin_reply')->nullable();
            $table->timestamp('admin_replied_at')->nullable();
            $table->longText('message')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'No Show'])->default('pending');
            $table->unsignedBigInteger('room_id')->nullable();
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->unsignedBigInteger('facility_id')->nullable();
            $table->foreign('facility_id')->references('id')->on('facilities')->onDelete('set null');
            $table->string('reservation_type', 20)->default('room');
            $table->unsignedBigInteger('assigned_room_id')->nullable();
            $table->foreign('assigned_room_id')->references('id')->on('rooms')->onDelete('set null');
            $table->unsignedBigInteger('checked_in_by')->nullable();
            $table->foreign('checked_in_by')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('checked_out_by')->nullable();
            $table->foreign('checked_out_by')->references('id')->on('users')->onDelete('set null');
            $table->timestamp('checked_in_at')->nullable();
            $table->timestamp('checked_out_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
