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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->string('slug')->unique();
            $table->string('title_en');
            $table->string('title_ar');
            $table->longText('content_en');
            $table->longText('content_ar');
            
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
            
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
