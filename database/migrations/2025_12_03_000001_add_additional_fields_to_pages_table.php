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
        Schema::table('pages', function (Blueprint $table) {
            // About Us fields
            $table->string('company_name_en')->nullable();
            $table->string('company_name_ar')->nullable();
            $table->integer('founded_year')->nullable();
            $table->string('location_en')->nullable();
            $table->string('location_ar')->nullable();
            $table->longText('company_description_en')->nullable();
            $table->longText('company_description_ar')->nullable();
            $table->longText('history_en')->nullable();
            $table->longText('history_ar')->nullable();
            
            // Contact Us fields
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('address_en')->nullable();
            $table->string('address_ar')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->integer('map_zoom')->default(15);
            $table->longText('contact_description_en')->nullable();
            $table->longText('contact_description_ar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn([
                'company_name_en',
                'company_name_ar',
                'founded_year',
                'location_en',
                'location_ar',
                'company_description_en',
                'company_description_ar',
                'history_en',
                'history_ar',
                'email',
                'phone',
                'whatsapp',
                'address_en',
                'address_ar',
                'latitude',
                'longitude',
                'map_zoom',
                'contact_description_en',
                'contact_description_ar',
            ]);
        });
    }
};