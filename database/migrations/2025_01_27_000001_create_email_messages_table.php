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
        Schema::create('email_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('message_id')->unique(); // IMAP message ID
            $table->string('folder'); // INBOX, SENT, DRAFTS, STARRED, etc.
            $table->string('from_email');
            $table->string('from_name')->nullable();
            $table->string('to_email');
            $table->string('to_name')->nullable();
            $table->string('cc')->nullable();
            $table->string('bcc')->nullable();
            $table->string('subject');
            $table->longText('body');
            $table->longText('body_plain')->nullable();
            $table->longText('body_html')->nullable();
            $table->timestamp('date_received');
            $table->boolean('is_read')->default(false);
            $table->boolean('is_starred')->default(false);
            $table->boolean('has_attachments')->default(false);
            $table->json('attachments')->nullable(); // Store attachment info
            $table->timestamps();
            
            $table->index(['user_id', 'folder']);
            $table->index(['user_id', 'is_read']);
            $table->index(['user_id', 'is_starred']);
            $table->index(['user_id', 'date_received']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_messages');
    }
}; 