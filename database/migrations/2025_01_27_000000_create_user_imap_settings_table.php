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
        Schema::create('user_imap_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('provider')->default('custom'); // gmail, outlook, zoho, yahoo, custom
            $table->string('host');
            $table->integer('port');
            $table->string('username');
            $table->text('password');
            $table->string('encryption')->default('ssl'); // ssl, tls, notls
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_imap_settings');
    }
}; 