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
        Schema::table('sub_training_programs', function (Blueprint $table) {
            $table->dropColumn('program_date')->nullable();
            $table->dropColumn('program_register_deadline')->nullable();
            $table->dropColumn('participant_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sub_training_programs', function (Blueprint $table) {
            $table->string('program_date')->nullable();
            $table->string('program_register_deadline')->nullable();
            $table->string('participant_count')->default(0);
        });
    }
};
