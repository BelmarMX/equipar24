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
        Schema::create('reels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promotion_id')->nullable()->constrained('promotions')->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('cascade');
            $table->string('title', 384);
            $table->string('slug', 512);
            $table->string('video', 2040);
            $table->string('link', 2040)->nullable();
            $table->string('link_title', 128)->nullable();
            $table->string('link_summary', 512)->nullable();
            $table->dateTime('starts_at')->useCurrent();
            $table->dateTime('ends_at');
            $table->string('image', 2040)->nullable();
            $table->string('image_rx', 2040)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reels');
    }
};
