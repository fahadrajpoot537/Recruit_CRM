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
        Schema::create('crm_jobs', function (Blueprint $table) {
            $table->id();

            // Basic Job Information
            $table->string('job_title');
            $table->integer('no_of_openings');
            $table->foreignId('company_id')->constrained('companies');
            $table->foreignId('target_company_id')->nullable()->constrained('companies');

            // Job Details
            $table->text('job_description');
            $table->string('location_type'); // Onsite, Remote, Hybrid
            $table->string('job_type');
            $table->string('job_category')->nullable();

            // Experience Requirements
            $table->integer('min_experience')->default(0); // Years
            $table->integer('max_experience')->default(0); // Years

            // Salary Information
            $table->string('salary_type'); // Annual, Monthly, etc.
            $table->string('currency')->nullable();
            $table->decimal('min_salary', 12, 2)->nullable();
            $table->decimal('max_salary', 12, 2)->nullable();

            // Education Requirements
            $table->string('educational_qualification')->nullable();
            $table->string('educational_specialization')->nullable();
            $table->string('skills')->nullable();

            // Location Information
            $table->string('locality')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('postal_code')->nullable();
            $table->text('full_address')->nullable();

            // Team & Process
            $table->foreignId('owner_id')->constrained('users');
            $table->foreignId('collaborator_id')->nullable()->constrained('users');
            $table->text('note_for_candidates')->nullable();

            $table->text('attachments')->nullable();

            // Status & Timestamps
            $table->string('status')->default('Open');
            $table->timestamp('published_at')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->unsignedBigInteger('primary_contact_id')->nullable();
            $table->foreign('primary_contact_id')->references('id')->on('contacts');
            $table->timestamps();
            $table->softDeletes();
        });

        // Pivot table for job questions (alternative to JSON column)

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
