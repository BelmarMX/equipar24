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
        Schema::table('form_submits', function (Blueprint $table) {
            $table->boolean('is_sold')->default(0)->after('rejected_at');
			$table->foreignId('marked_sold_by')->nullable()->constrained('users')->onDelete('cascade')->after('is_sold');
			$table->dateTime('marked_sold_at')->nullable()->after('marked_sold_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_submits', function (Blueprint $table) {
            $table->dropColumn('marked_sold_at');
            $table->dropColumn('marked_sold_by');
            $table->dropColumn('is_sold');
        });
    }
};
