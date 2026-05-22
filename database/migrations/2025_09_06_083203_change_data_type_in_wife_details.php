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
        Schema::table('wife_details', function (Blueprint $table) {
            $table->dropColumn(['taluka', 'village']);

            // Add foreign keys
            $table->foreignId('taluka')->nullable()->after('city')->constrained('talukas')->onDelete('cascade');
            $table->foreignId('village')->nullable()->after('taluka')->constrained('villages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wife_details', function (Blueprint $table) {
            $table->dropForeign(['taluka']);
            $table->dropForeign(['village']);
            $table->dropColumn(['taluka', 'village']);

            // Restore old columns
            $table->string('taluka')->nullable();
            $table->string('village')->nullable();
        });
    }
};
