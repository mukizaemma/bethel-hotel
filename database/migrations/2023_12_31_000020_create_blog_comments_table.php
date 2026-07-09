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
        if (!Schema::hasTable('blog_comments')) {
            Schema::create('blog_comments', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('blog_id');
                $table->unsignedBigInteger('added_by')->nullable();
                $table->string('names');
                $table->string('email');
                $table->text('comment');
                $table->enum('status', ['pending', 'Published', 'rejected'])->default('pending');
                $table->timestamp('published_at')->nullable();
                $table->timestamps();

                $table->foreign('blog_id')->references('id')->on('blogs')->onDelete('cascade');
                $table->foreign('added_by')->references('id')->on('users')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_comments');
    }
};
