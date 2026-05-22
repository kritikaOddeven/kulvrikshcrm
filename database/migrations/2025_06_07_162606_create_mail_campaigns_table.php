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
        Schema::create('mail_campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')->nullable()->constrained('email_templates')->onDelete('cascade');
            $table->date('start_date')->nullable();
            $table->time('start_time')->nullable();
            $table->json('selected_emails')->nullable();
            $table->integer('total_person')->default(0);
            $table->enum('status', ['pending', 'running', 'complete'])->default('pending');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mail_campaigns');
    }
};
