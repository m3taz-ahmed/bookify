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
        Schema::table('customers', function (Blueprint $table) {
            // Make email and password nullable since we're using phone-based auth
            $table->string('email')->nullable()->change();
            $table->string('password')->nullable()->change();
            
            // Ensure phone is required and unique
            $table->string('phone')->nullable(false)->unique()->change();
            
            // Add OTP related fields
            $table->string('otp_code')->nullable();
            $table->timestamp('otp_expires_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('email')->nullable(false)->change();
            $table->string('password')->nullable(false)->change();
            $table->string('phone')->nullable()->change();
            
            $table->dropColumn(['otp_code', 'otp_expires_at']);
        });
    }
};