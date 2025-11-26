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
        Schema::table('services', function (Blueprint $table) {
            // Remove the old fields
            $table->dropColumn(['name', 'duration_minutes', 'description']);
            
            // Add the new multilingual fields
            $table->string('name_en')->after('id');
            $table->string('name_ar')->after('name_en');
            $table->text('description_en')->nullable()->after('name_ar');
            $table->text('description_ar')->nullable()->after('description_en');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            // Remove the new fields
            $table->dropColumn(['name_en', 'name_ar', 'description_en', 'description_ar']);
            
            // Add back the old fields
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('duration_minutes');
        });
    }
};