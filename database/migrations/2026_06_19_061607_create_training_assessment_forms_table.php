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
        Schema::create('training_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('form_group_id')->constrained('training_assessment_groups')->onDelete('cascade');
            $table->string('form_title')->nullable();
            $table->date('form_date')->nullable();
            $table->string('form_venue')->nullable();
            $table->string('form_provider')->nullable();
            $table->boolean('is_benefit')->nullable();
            $table->boolean('is_relevant')->nullable();
            $table->string('status')->default(1);
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamp('pre_submitted_on')->nullable();
            $table->timestamp('post_submitted_on')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('training_assessments', function (Blueprint $table) {
            $table->dropForeign('user_id');
            $table->dropForeign('form_group_id');
        });

        Schema::dropIfExists('training_assessments');
    }
};

