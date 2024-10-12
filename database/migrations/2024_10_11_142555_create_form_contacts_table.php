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
        Schema::create('form_contacts', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('name', 254);
            $table->string('email', 254)->unique();
            $table->string('phone', 16)->nullable();
            $table->string('company', 254)->nullable();
            $table->string('city', 128)->nullable();
            $table->string('state', 64)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_contacts');
    }
};
