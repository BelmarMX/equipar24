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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_category_id')->constrained('product_categories')->onDelete('cascade');
            $table->foreignId('product_subcategory_id')->constrained('product_subcategories')->onDelete('cascade');
            $table->foreignId('product_brand_id')->constrained('product_brands')->onDelete('cascade');
            $table->string('title', 384);
            $table->string('slug', 512);
            $table->string('model', 256);
            $table->string('summary', 256);
            $table->text('features')->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->boolean('is_featured')->default(false);
            $table->boolean('with_freight')->default(false);
            $table->string('image', 2040)->nullable();
            $table->string('image_rx', 2040)->nullable();
            $table->string('data_sheet', 2040)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table -> unique(['product_category_id', 'product_subcategory_id', 'product_brand_id', 'slug'], 'products_category_subcategory_brand_slug_unique');
            $table -> unique(['product_category_id', 'product_subcategory_id', 'product_brand_id', 'model'], 'products_category_subcategory_brand_model_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
