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
        Schema::create('stripe_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->integer('customer_id');
            $table->integer('total');
            $table->integer('discount');
            $table->integer('payment_method');
            $table->integer('charge');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->integer('country_id');
            $table->integer('city_id');
            $table->integer('zip');
            $table->string('company')->nullable();
            $table->string('additional')->nullable();
            $table->string('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stripe_orders');
    }
};
