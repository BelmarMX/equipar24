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
        Schema::create('product_packages', function (Blueprint $table) {
            $table->id();
	        $table->string('title', 384);
	        $table->string('slug', 512);
	        $table->string('summary', 256);
	        $table->text('content')->nullable();
	        $table->decimal('price', 10, 2);
	        $table->string('image', 2040);
	        $table->string('image_rx', 2040)->nullable();
	        $table->text('raw_editor')->nullable();
	        $table->dateTime('starts_at')->useCurrent();
	        $table->dateTime('ends_at');
            $table->timestamps();
			$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_packages');
    }
};
