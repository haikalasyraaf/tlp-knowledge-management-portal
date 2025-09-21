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
        Schema::create('tni_programs', function (Blueprint $table) {
            $table->id();
            $table->string('image_path')->nullable();
            $table->string('program_name')->nullable();
            $table->string('program_description')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('tni_competencies', function (Blueprint $table) {
            $table->id();
            $table->string('tni_program_id')->nullable();
            $table->string('image_path')->nullable();
            $table->string('competency_name')->nullable();
            $table->string('competency_description')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('tni_courses', function (Blueprint $table) {
            $table->id();
            $table->string('tni_competency_id')->nullable();
            $table->string('course_name')->nullable();
            $table->string('course_objective')->nullable();
            $table->string('course_duration')->nullable();
            $table->string('course_cost')->nullable();
            $table->string('course_category')->nullable();
            $table->string('participant_count')->default(0);
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
        Schema::dropIfExists('tni_programs');
        Schema::dropIfExists('tni_competencies');
        Schema::dropIfExists('tni_courses');
    }
};
