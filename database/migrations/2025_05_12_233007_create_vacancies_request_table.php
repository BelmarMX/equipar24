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
        Schema::create('vacancies_request', function (Blueprint $table) {
            $table->id();
	        $table->foreignId('vacancy_id')->nullable()->constrained('vacancies')->onDelete('set null');
	        $table->string('name', 254);
	        $table->string('email', 254);
	        $table->string('phone', 16)->nullable();
			$table->string('file', 2048)->nullable();
            $table->timestamps();
			$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacancies_request');
    }
};
