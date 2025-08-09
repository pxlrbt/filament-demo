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
        Schema::create('theme_configurations', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();
            $table->string('email');

            $table->json('configuration');

            $table->string('purchase_token')->unique();
            $table->string('license_type'); // 'business' or 'unlimited'
            $table->string('payment_status')->default('pending'); // pending, completed, failed
            $table->string('lemon_squeezy_order_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('theme_configurations');
    }
};
