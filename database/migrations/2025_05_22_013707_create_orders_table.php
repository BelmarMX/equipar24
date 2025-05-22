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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
			$table->uuid();
	        $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
	        $table->foreignId('shopping_cart_id')->nullable()->constrained()->nullOnDelete();
	        $table->string('buyer_name');
	        $table->string('buyer_email');
	        $table->string('buyer_phone')->nullable();
	        $table->text('billing_address');
	        $table->text('shipping_address')->nullable();
	        $table->enum('status', ['pending', 'paid', 'sent', 'delivered'])->default('pending'); // pendiente, pagado, enviado, entregado
	        $table->enum('payment_status', ['pending', 'completed', 'failed'])->default('pending'); // pendiente, completo, fallido
	        $table->string('payment_method')->nullable();
	        $table->decimal('amount', 10, 2);
	        $table->decimal('discount', 10, 2);
	        $table->decimal('total', 10, 2);
	        $table->text('notes')->nullable();
			$table->unsignedSmallInteger('rating')->default(0);
	        $table->text('comments')->nullable();
            $table->timestamps();
			$table->softDeletes();

			$table->index('uuid', 'orders_uuid');
			$table->index('buyer_email', 'orders_buyer_email');
			$table->index('status', 'orders_status');
			$table->index('payment_status', 'orders_payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
