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
        Schema::create('training_assessment_pre_questions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('training_id')
                ->constrained('training_assessments')
                ->onDelete('cascade');

            // question template
            $table->string('question_category');
            $table->string('question_text');
            $table->string('question_type')->default('scale');

            // answers
            $table->integer('answer_value')->nullable(); // scale 1–5
            $table->text('answer_text')->nullable();     // text question

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_assessment_pre_questions');
    }
};

