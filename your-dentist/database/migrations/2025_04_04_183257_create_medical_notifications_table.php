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
        // No need to create notifications table as we don't want notifications in our project
        if (Schema::hasTable('notifications')) {
            Schema::dropIfExists('notifications');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to recreate the table in down() since we're removing notifications entirely
    }
};
