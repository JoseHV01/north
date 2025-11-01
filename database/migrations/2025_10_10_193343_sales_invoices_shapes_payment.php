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
        Schema::create('sales_invoices_shapes_payment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_sales_invoice');
            $table->unsignedBigInteger('id_shape_payment');
            $table->double('amount');
            $table->double('price_BCV');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
