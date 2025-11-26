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
        // Check if the old columns exist before trying to drop them
        if (Schema::hasColumn('services', 'name') || 
            Schema::hasColumn('services', 'duration_minutes') || 
            Schema::hasColumn('services', 'description')) {
            
            Schema::table('services', function (Blueprint $table) {
                // Remove the old fields if they exist
                if (Schema::hasColumn('services', 'name')) {
                    $table->dropColumn('name');
                }
                if (Schema::hasColumn('services', 'duration_minutes')) {
                    $table->dropColumn('duration_minutes');
                }
                if (Schema::hasColumn('services', 'description')) {
                    $table->dropColumn('description');
                }
            });
        }
        
        // Add the new multilingual fields if they don't exist
        Schema::table('services', function (Blueprint $table) {
            if (!Schema::hasColumn('services', 'name_en')) {
                $table->string('name_en')->after('id');
            }
            if (!Schema::hasColumn('services', 'name_ar')) {
                $table->string('name_ar')->after('name_en');
            }
            if (!Schema::hasColumn('services', 'description_en')) {
                $table->text('description_en')->nullable()->after('name_ar');
            }
            if (!Schema::hasColumn('services', 'description_ar')) {
                $table->text('description_ar')->nullable()->after('description_en');
            }
            // Add duration_minutes back if it doesn't exist
            if (!Schema::hasColumn('services', 'duration_minutes')) {
                $table->integer('duration_minutes')->after('description_ar');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            // Remove the new fields if they exist
            if (Schema::hasColumn('services', 'name_en')) {
                $table->dropColumn('name_en');
            }
            if (Schema::hasColumn('services', 'name_ar')) {
                $table->dropColumn('name_ar');
            }
            if (Schema::hasColumn('services', 'description_en')) {
                $table->dropColumn('description_en');
            }
            if (Schema::hasColumn('services', 'description_ar')) {
                $table->dropColumn('description_ar');
            }
            if (Schema::hasColumn('services', 'duration_minutes')) {
                $table->dropColumn('duration_minutes');
            }
            
            // Add back the old fields
            if (!Schema::hasColumn('services', 'name')) {
                $table->string('name');
            }
            if (!Schema::hasColumn('services', 'description')) {
                $table->text('description')->nullable();
            }
            if (!Schema::hasColumn('services', 'duration_minutes')) {
                $table->integer('duration_minutes');
            }
        });
    }
};