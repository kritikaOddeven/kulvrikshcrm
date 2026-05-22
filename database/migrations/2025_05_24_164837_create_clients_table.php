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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('kulvrisk_id')->nullable();
            $table->foreignId('lead_id')->nullable()->constrained('leads')->onDelete('cascade');
            $table->json('researcher_ids')->nullable();
            $table->foreignId('agent_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->json('project_ids')->nullable();
            $table->json('sub_project_ids')->nullable();
            $table->string('payment_mode')->default('Cash');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('image_path')->nullable();
            $table->longText('description')->nullable();
            $table->boolean('is_researchar_report')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
