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
        Schema::table('researcher_reports', function (Blueprint $table) {
            $table->string('history_title')->nullable()->after('description');
            $table->longText('history_description')->nullable()->after('history_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('researcher_reports', function (Blueprint $table) {
            //
        });
    }
};
