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
        Schema::table('products', function (Blueprint $table) {
			$table->string('sku')->nullable()->after('id');
            $table->enum('availability', ['in_stock', 'on_request', 'quotation_only'])->default('quotation_only')->after('with_freight');
			$table->unsignedInteger('quantity')->nullable()->after('availability');
			$table->unsignedInteger('purchase_limit')->nullable()->after('quantity');
			$table->unsignedInteger('delivery_deadline')->default(0)->after('purchase_limit');
			$table->decimal('weight', 8, 2)->nullable()->after('raw_editor');
			$table->decimal('length', 8, 2)->nullable()->after('weight');
			$table->decimal('width', 8, 2)->nullable()->after('length');
			$table->decimal('height', 8, 2)->nullable()->after('width');
			$table->boolean('is_fragile')->default(false)->after('height');
			$table->boolean('is_perishable')->default(false)->after('is_fragile');
			$table->boolean('requires_signature')->default(false)->after('is_perishable');
			$table->boolean('hazardous')->default(false)->after('requires_signature');
			$table->string('shipping_class')->nullable()->after('hazardous');

			$table->index('sku', 'sku_index');
			$table->index('availability', 'availability_index');
			$table->index('shipping_class', 'shipping_class_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
	        $table->dropIndex('sku_index');
	        $table->dropIndex('availability_index');
	        $table->dropIndex('shipping_class_index');

	        $table->dropColumn('sku');
	        $table->dropColumn('availability');
	        $table->dropColumn('quantity');
	        $table->dropColumn('purchase_limit');
	        $table->dropColumn('delivery_deadline');
	        $table->dropColumn('weight');
	        $table->dropColumn('length');
	        $table->dropColumn('width');
	        $table->dropColumn('height');
	        $table->dropColumn('is_fragile');
	        $table->dropColumn('is_perishable');
	        $table->dropColumn('requires_signature');
	        $table->dropColumn('hazardous');
	        $table->dropColumn('shipping_class');
        });
    }
};
