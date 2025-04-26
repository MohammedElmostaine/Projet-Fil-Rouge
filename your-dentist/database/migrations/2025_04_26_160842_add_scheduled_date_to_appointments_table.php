<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->date('scheduled_date')->nullable()->after('end_datetime');
        });

        // Update existing records to initialize scheduled_date from start_datetime
        DB::statement('UPDATE appointments SET scheduled_date = DATE(start_datetime) WHERE scheduled_date IS NULL AND start_datetime IS NOT NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('scheduled_date');
        });
    }
};
