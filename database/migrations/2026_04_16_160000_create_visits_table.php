<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->string('session_id', 120)->nullable()->index();
            $table->string('ip_address', 45)->nullable()->index();
            $table->text('user_agent')->nullable();
            $table->text('referrer')->nullable();
            $table->string('method', 10)->default('GET');
            // Indexable length: utf8mb4 × 2048 chars exceeds MySQL's max key length; request path() is short; full URL is in `url`.
            $table->string('path', 512)->nullable()->index();
            $table->text('url')->nullable();
            $table->string('country_code', 8)->nullable()->index();
            $table->timestamp('visited_at')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
