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
        Schema::create('shopping_carts', function (Blueprint $table) {
            $table->id();
	        $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
	        $table->string('session_id')->nullable();
	        $table->enum('status', ['active', 'abandoned', 'purchased', 'canceled'])->default('active');
            $table->timestamps();
			$table->softDeletes();

			$table->index('status', 'shopping_carts_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shopping_carts');
    }
};
