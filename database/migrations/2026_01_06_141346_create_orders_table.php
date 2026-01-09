<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Customer optional (walk-in)
            $table->string('customer_name')->nullable();
            $table->string('customer_phone')->nullable();

            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);

            $table->string('payment_method')->default('cash'); // cash/online/card
            $table->string('notes')->nullable();

            $table->unsignedBigInteger('created_by')->nullable(); // optional (admin id)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
