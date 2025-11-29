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
        Schema::create('training_requests', function (Blueprint $table) {
            $table->id();
            $table->string('requestor_name')->nullable();
            $table->string('deparment_name')->nullable();
            $table->date('date_requested')->nullable();
            $table->string('training_title')->nullable();
            $table->string('training_organiser')->nullable();
            $table->string('training_venue')->nullable();
            $table->date('training_start_date')->nullable();
            $table->date('training_end_date')->nullable();
            $table->string('training_cost')->nullable();
            $table->string('approved_training_cost')->nullable();
            $table->string('employees_recommended')->nullable();
            $table->longText('training_objective')->nullable();
            $table->longText('remarks')->nullable();
            $table->string('status')->default(1);
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('training_request_statuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('training_request_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('status_type')->nullable(); // REVIEWER OR APPROVER
            $table->string('transport_to_venue')->nullable();
            $table->string('approved_training_cost')->nullable();
            $table->string('is_accomodation_required')->nullable();
            $table->string('is_hdrc_claimable')->nullable();
            $table->string('is_budget_under_atp')->nullable();
            $table->string('approval_decision')->nullable();
            $table->longText('remarks')->nullable();
            $table->timestamps();
        });

        Schema::create('training_request_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('training_request_id')->nullable();
            $table->string('document_name')->nullable();
            $table->string('document_path')->nullable();
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
        Schema::dropIfExists('training_requests');
        Schema::dropIfExists('training_request_statuses');
        Schema::dropIfExists('training_request_documents');
    }
};
