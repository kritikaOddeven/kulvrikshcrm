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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('added_by')->constrained('users')->onDelete('cascade');
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->foreignId('country')->constrained('countries');
            $table->foreignId('state')->constrained('states');
            $table->foreignId('district')->constrained('districts');
            $table->foreignId('city')->constrained('cities');
            $table->string('taluka')->nullable();
            $table->string('village')->nullable();
            $table->date('birth_date')->nullable();
            $table->date('marriage_date')->nullable();
            $table->text('notes')->nullable();
            $table->text('lead_ancestor_notes')->nullable();
            $table->text('wife_ancestor_notes')->nullable();
            $table->enum('status', ['high', 'low', 'done', 'close'])->default('low');
            $table->boolean('is_lead_to_client')->default(false);
            $table->string('original_language')->nullable();
            $table->string('translated_language')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('wife_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads')->onDelete('cascade');
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->date('birth_date')->nullable();
            $table->date('marriage_date')->nullable();
            $table->date('death_date')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
           $table->foreignId('country')->nullable()->constrained('countries');
            $table->foreignId('state')->nullable()->constrained('states');
            $table->foreignId('district')->nullable()->constrained('districts');
            $table->foreignId('city')->nullable()->constrained('cities');
            $table->string('taluka')->nullable();
            $table->string('village')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('families', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads')->onDelete('cascade');
            $table->enum('belongs_to', ['lead', 'wife'])->default('lead');
            $table->string('relation'); // grandfather, great-grandmother, etc.
            $table->string('name')->nullable();
            $table->date('birth_date')->nullable();
            $table->date('marriage_date')->nullable();
            $table->date('death_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('siblings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads')->onDelete('cascade');
            $table->enum('belongs_to', ['lead', 'wife'])->default('lead');
            $table->enum('relation', ['brother', 'sister'])->default('brother');
            $table->string('name');
            $table->date('birth_date')->nullable();
            $table->date('death_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('lineages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads')->onDelete('cascade');
            $table->enum('belongs_to', ['lead', 'wife'])->default('lead');
            $table->string('lineage')->nullable();
            $table->string('caste')->nullable();
            $table->string('sub_caste')->nullable();
            $table->string('surname')->nullable();
            $table->string('gotra')->nullable();
            $table->string('kuldevi')->nullable();
            $table->string('kuldevta')->nullable();
            $table->string('primary_clan')->nullable();
            $table->string('sub_clan')->nullable();
            $table->string('khap')->nullable();
            $table->string('rulership')->nullable();
            $table->string('spiritual_seat')->nullable();
            $table->string('ancestral_village')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('children', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads')->onDelete('cascade');
            $table->enum('gender', ['male', 'female'])->default('male');
            $table->string('name')->nullable();
            $table->date('birth_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('lead_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads')->onDelete('cascade');
            $table->foreignId('added_by')->constrained('users')->onDelete('cascade');
            $table->longText('original_content')->nullable();
            $table->longText('content')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('lead_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads')->onDelete('cascade');
            $table->foreignId('note_id')->nullable()->constrained('lead_notes')->onDelete('cascade');
            $table->string('attachment');
            $table->string('type');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
        Schema::dropIfExists('wife_details');
        Schema::dropIfExists('families');
        Schema::dropIfExists('siblings');
        Schema::dropIfExists('lineages');
        Schema::dropIfExists('children');
        Schema::dropIfExists('lead_notes');
        Schema::dropIfExists('lead_attachments');
    }
};
