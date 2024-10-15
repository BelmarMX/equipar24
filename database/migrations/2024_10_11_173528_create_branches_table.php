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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('state_id')->constrained('states')->onDelete('cascade');
            $table->foreignId('city_id')->constrained('cities')->onDelete('cascade');
            $table->string('title', 384);
            $table->string('street');
            $table->string('number');
            $table->string('neighborhood');
            $table->string('building')->nullable();
            $table->string('country')->default('México');
            $table->string('link')->nullable();
            $table->string('embed_code')->nullable();
            $table->string('image', 2040);
            $table->string('image_rx', 2040);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
