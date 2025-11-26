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
        Schema::table('bookings', function (Blueprint $table) {
            $table->integer('number_of_people')->default(1)->after('customer_id');
            $table->text('qr_code')->nullable()->after('number_of_people');
            $table->string('payment_method')->nullable()->after('qr_code');
            $table->string('order_ref')->nullable()->after('payment_method');
            $table->boolean('is_paid')->default(false)->after('order_ref');
            $table->tinyInteger('rating')->nullable()->after('is_paid');
            $table->text('review')->nullable()->after('rating');
            $table->text('notes')->nullable()->after('review');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['number_of_people', 'qr_code', 'payment_method', 'order_ref', 'is_paid', 'rating', 'review', 'notes']);
        });
    }
};