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
        Schema::create('blog_articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_category_id')->constrained('blog_categories')->onDelete('cascade');
            $table->string('title', 384);
            $table->string('slug', 512);
            $table->string('summary', 256);
            $table->text('content')->nullable();
            $table->string('image', 2040);
            $table->string('image_rx', 2040)->nullable();
            $table->text('raw_editor')->nullable();
            $table->dateTime('published_at')->useCurrent();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['blog_category_id', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_articles');
    }
};
