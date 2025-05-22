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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
	        $table->foreignId('order_id')->unique()->constrained()->onDelete('cascade');
	        $table->text('shipping_address');
	        $table->string('carrier')->nullable(); // DHL, Estafeta, etc.
	        $table->string('tracking_number')->nullable();
	        $table->timestamp('shipped_at')->nullable();
	        $table->timestamp('delivered_at')->nullable();
	        $table->timestamp('canceled_at')->nullable();
	        $table->enum('status', ['pending', 'sent', 'delivered', 'failed', 'returned'])->default('pending'); // pendiente, enviado, entregado, fallido
	        $table->text('notes')->nullable();
            $table->timestamps();
			$table->softDeletes();

			$table->index('tracking_number', 'shipments_tracking_number');
			$table->index('status', 'shipments_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
