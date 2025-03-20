<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	const TABLE_NAME = 'reels';

	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::table(self::TABLE_NAME, function (Blueprint $table) {
			$table->unsignedBigInteger('product_package_id')->nullable()->after('product_id')->index();
			$table->foreign('product_package_id')->references('id')->on('product_packages')->onDelete('SET NULL');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::table(self::TABLE_NAME, function (Blueprint $table) {
			$table->dropColumn('product_package_id');
		});
	}
};
