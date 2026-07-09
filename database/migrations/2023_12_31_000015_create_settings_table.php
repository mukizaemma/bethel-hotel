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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('company')->nullable();
            $table->text('address')->nullable();
            $table->text('google_map_embed')->nullable();
            $table->string('phone')->nullable();
            $table->string('reception_phone')->nullable();
            $table->string('manager_phone')->nullable();
            $table->string('restaurant_phone')->nullable();
            $table->string('email')->nullable();
            $table->string('logo')->nullable();
            $table->string('donate')->nullable();
            $table->text('deliveryInfo')->nullable();
            $table->text('quote')->nullable();
            $table->string('keywords')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('youtube')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('linktree')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
