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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            
            // PayMob specific fields
            $table->string('paymob_order_id')->nullable()->index();
            $table->string('paymob_transaction_id')->nullable()->index();
            $table->string('merchant_order_id')->unique();
            $table->string('paymob_integration_id')->nullable();
            
            // Payment details
            $table->unsignedBigInteger('amount_cents');
            $table->string('currency', 3)->default('SAR');
            $table->string('payment_method')->nullable(); // card, wallet, etc.
            $table->string('payment_gateway')->default('paymob'); // Future-proof for other gateways
            
            // Payment status tracking
            $table->enum('payment_status', [
                'pending',
                'processing',
                'success',
                'failed',
                'refunded',
                'partially_refunded',
                'voided'
            ])->default('pending')->index();
            
            // Additional payment data
            $table->json('payment_data')->nullable(); // Full PayMob intention response
            $table->json('callback_data')->nullable(); // Webhook/callback data
            $table->text('failed_reason')->nullable();
            
            // Refund tracking
            $table->unsignedBigInteger('refund_amount_cents')->default(0);
            $table->timestamp('refunded_at')->nullable();
            
            // Payment timestamps
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            
            $table->timestamps();
            
            // Indexes for better query performance
            $table->index(['booking_id', 'payment_status']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
