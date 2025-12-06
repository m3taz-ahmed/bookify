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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('reference_code')->unique();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('set null');
            $table->foreignId('service_id')->nullable()->constrained('services')->onDelete('cascade');
            $table->date('booking_date');
            $table->time('start_time')->nullable();
            $table->integer('number_of_people')->default(1);
            $table->text('qr_code')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('order_ref')->nullable();
            $table->boolean('is_paid')->default(false);
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
            $table->string('payment_status')->nullable();
            $table->tinyInteger('rating')->nullable();
            $table->text('review')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['booking_date', 'start_time']);
            $table->index('reference_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
