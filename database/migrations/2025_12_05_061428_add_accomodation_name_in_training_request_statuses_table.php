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
        Schema::table('training_request_statuses', function (Blueprint $table) {
            $table->string('transportation_remark')->nullable()->after('transport_to_venue');
            $table->string('training_duration')->nullable()->after('approved_training_cost');
            $table->string('accommodation_name')->nullable()->after('is_budget_under_atp');
            $table->string('internal_or_external')->nullable()->after('accommodation_name');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('training_request_statuses', function (Blueprint $table) {
            $table->dropColumn('transportation_remark');
            $table->dropColumn('training_duration');
            $table->dropColumn('accommodation_name');
            $table->dropColumn('internal_or_external');
        });
    }
};
