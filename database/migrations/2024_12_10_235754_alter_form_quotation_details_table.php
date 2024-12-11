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
        Schema::table('form_quotation_details', function (Blueprint $table) {
            $table->string('product_model')->nullable()->after('product_name');
            $table->string('product_brand')->nullable()->after('product_model');
            $table->string('product_image', 2048)->nullable()->after('product_brand');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_quotation_details', function (Blueprint $table) {
            $table->dropColumn('product_model');
            $table->dropColumn('product_brand');
            $table->dropColumn('product_image');
        });
    }
};
