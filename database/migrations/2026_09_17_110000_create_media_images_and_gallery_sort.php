<?php

use App\Services\MediaLibrary;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media_images', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->string('original_name')->nullable();
            $table->string('mime')->nullable();
            $table->unsignedBigInteger('size')->default(0);
            $table->string('hash', 32)->unique();
            $table->timestamps();
        });

        Schema::table('galleries', function (Blueprint $table) {
            $table->foreignId('media_image_id')->nullable()->after('id')->constrained('media_images')->nullOnDelete();
            $table->unsignedInteger('sort_order')->default(0)->after('category');
        });

        app(MediaLibrary::class)->importExistingContent();
    }

    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropConstrainedForeignId('media_image_id');
            $table->dropColumn('sort_order');
        });
        Schema::dropIfExists('media_images');
    }
};
