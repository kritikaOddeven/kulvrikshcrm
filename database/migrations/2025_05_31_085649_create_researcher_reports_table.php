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
        Schema::create('researcher_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()->constrained('clients')->onDelete('cascade');
            $table->longText('top_tagline')->nullable();
            $table->longText('kul_tagline')->nullable();

            // Personal Info
            $table->string('name')->nullable();
            $table->string('surname')->nullable();

            // Lineage Info
            $table->string('lineage')->nullable();
            $table->string('credit')->nullable();
            $table->string('caste')->nullable();
            $table->string('subspecies')->nullable();
            $table->string('gotra')->nullable();
            $table->string('pravar')->nullable();
            $table->string('vedas')->nullable();
            $table->string('upaveda')->nullable();
            $table->string('branch')->nullable();
            $table->string('peak')->nullable();
            $table->string('formula')->nullable();
            $table->string('gotra_devi')->nullable();
            $table->string('ishta_devi')->nullable();
            $table->string('ishtadev')->nullable();
            $table->string('kuldevi')->nullable();
            $table->string('kuldevata')->nullable();
            $table->string('supportive_mother')->nullable();
            $table->string('river')->nullable();
            $table->string('ancestor_shrine')->nullable();
            $table->string('tirth_purohit')->nullable();
            $table->string('original_location')->nullable();
            $table->string('kuldevi_dash')->nullable();
            $table->string('patriarchy')->nullable();

            // File Upload
            $table->string('image')->nullable();

            // Final Content
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->string('translated_language')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('researcher_reports');
    }
};
