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
        Schema::create('product_package_products', function (Blueprint $table) {
            $table->id();
	        $table->foreignId('product_package_id')->constrained('product_packages')->onDelete('cascade');
	        $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->timestamps();

	        $table->unique(['product_package_id', 'product_id'])->name('uniquepackages');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_package_products');
    }
};
