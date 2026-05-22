<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campaign_email_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained('mail_campaigns')->onDelete('cascade');
            $table->string('email');
            $table->string('client_id');
            $table->enum('status', ['pending', 'sent', 'failed'])->default('pending');
            $table->text('error_message')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaign_email_logs');
    }
}; 