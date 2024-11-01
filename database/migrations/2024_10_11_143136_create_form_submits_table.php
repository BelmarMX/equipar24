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
        Schema::create('form_submits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_contact_id')->constrained('form_contacts')->onDelete('cascade');
            $table->enum('type', ['contact', 'quotation'])->default('contact');
            $table->string('comment', 1024)->nullable();
            $table->string('notes', 1024)->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('approved_by_user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('rejected_by_user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->dateTime('approved_at')->nullable();
            $table->dateTime('rejected_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_submits');
    }
};
