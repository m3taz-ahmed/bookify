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
            // Remove customer_name and customer_phone columns
            $table->dropColumn(['customer_name', 'customer_phone']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Add back customer_name and customer_phone columns
            $table->string('customer_name')->after('reference_code');
            $table->string('customer_phone')->after('customer_name');
        });
    }
};