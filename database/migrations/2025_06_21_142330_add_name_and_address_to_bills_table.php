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
        Schema::table('bills', function (Blueprint $table) {
            $table->string('name')->after('invoice_number')->nullable();
            $table->text('address')->after('gst_number')->nullable();
            $table->string('type')->after('gst_number')->nullable();
            $table->string('sac_number')->after('type')->nullable();
            $table->string('payment_terms')->after('sac_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bills', function (Blueprint $table) {
             $table->dropColumn(['name', 'address']);
        });
    }
};
