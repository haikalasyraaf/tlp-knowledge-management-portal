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
        Schema::create('training_program_folders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('training_program_id')->nullable();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default(1);
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('training_program_folder_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('training_program_id')->nullable();
            $table->unsignedBigInteger('training_program_folder_id')->nullable();
            $table->string('document_name')->nullable();
            $table->string('document_path')->nullable();
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
        Schema::dropIfExists('training_program_folders');
        Schema::dropIfExists('training_program_folder_documents');
    }
};
