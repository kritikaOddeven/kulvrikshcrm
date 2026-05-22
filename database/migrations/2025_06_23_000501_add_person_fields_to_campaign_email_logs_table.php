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
        Schema::table('campaign_email_logs', function (Blueprint $table) {
            $table->string('person_name')->nullable()->after('client_id');
            $table->string('person_type')->default('lead')->after('person_name');
            $table->string('relation')->nullable()->after('person_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campaign_email_logs', function (Blueprint $table) {
            $table->dropColumn(['person_name', 'person_type', 'relation']);
        });
    }
};
