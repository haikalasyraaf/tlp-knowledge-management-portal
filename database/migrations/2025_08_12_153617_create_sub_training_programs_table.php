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
        Schema::create('sub_training_programs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('training_program_id')->nullable();
            $table->string('program_date')->nullable();
            $table->string('program_register_deadline')->nullable();
            $table->string('program_name')->nullable();
            $table->string('program_description')->nullable();
            $table->string('document_path')->nullable();
            $table->string('participant_count')->default(0);
            $table->string('status')->default(1);
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_training_programs');
    }
};
