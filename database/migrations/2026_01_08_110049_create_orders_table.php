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
            $table->uuid('uuid')->unique();
            $table->uuid('customer_uuid');
            $table->uuid('outlet_uuid');
            $table->string('invoice_code')->unique();
            $table->string('order_code')->unique();
            $table->dateTime('order_date');
            $table->integer('total_price')->default(0);
            $table->integer('paid_amount')->default(0);
            $table->enum('payment_status', ['Belum', 'DP', 'Lunas'])->default('Belum');
            $table->enum('status', ['diterima', 'cuci', 'jemur', 'setrika', 'selesai', 'diambil'])->default('diterima');
            $table->timestamps();
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
