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
        // Check if columns exist before adding them to avoid duplicates
        if (!Schema::hasColumn('pages', 'company_description_en')) {
            Schema::table('pages', function (Blueprint $table) {
                // About Us fields
                $table->longText('company_description_en')->nullable();
                $table->longText('company_description_ar')->nullable();
                $table->longText('history_en')->nullable();
                $table->longText('history_ar')->nullable();
                
                // Contact Us fields
                $table->longText('contact_description_en')->nullable();
                $table->longText('contact_description_ar')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            if (Schema::hasColumn('pages', 'company_description_en')) {
                $table->dropColumn([
                    'company_description_en',
                    'company_description_ar',
                    'history_en',
                    'history_ar',
                    'contact_description_en',
                    'contact_description_ar',
                ]);
            }
        });
    }
};