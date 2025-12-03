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
        if (!Schema::hasColumn('pages', 'company_name_en')) {
            Schema::table('pages', function (Blueprint $table) {
                // About Us fields
                $table->string('company_name_en')->nullable();
                $table->string('company_name_ar')->nullable();
                $table->integer('founded_year')->nullable();
                $table->string('location_en')->nullable();
                $table->string('location_ar')->nullable();
                
                // Skip company_description and history fields as they're added in another migration
                
                // Contact Us fields
                $table->string('email')->nullable();
                $table->string('phone')->nullable();
                $table->string('whatsapp')->nullable();
                $table->string('address_en')->nullable();
                $table->string('address_ar')->nullable();
                $table->decimal('latitude', 10, 8)->nullable();
                $table->decimal('longitude', 11, 8)->nullable();
                $table->integer('map_zoom')->default(15);
                
                // Skip contact_description fields as they're added in another migration
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            if (Schema::hasColumn('pages', 'company_name_en')) {
                $table->dropColumn([
                    'company_name_en',
                    'company_name_ar',
                    'founded_year',
                    'location_en',
                    'location_ar',
                    'email',
                    'phone',
                    'whatsapp',
                    'address_en',
                    'address_ar',
                    'latitude',
                    'longitude',
                    'map_zoom',
                ]);
            }
        });
    }
};