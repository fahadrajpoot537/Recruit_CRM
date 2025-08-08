<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParsedCvsTable extends Migration
{
    public function up()
    {
        Schema::create('parsed_cvs', function (Blueprint $table) {
            $table->id();
            $table->string('candidate_ref')->nullable();
            $table->string('cv_folder')->nullable();
            $table->boolean('opt_out')->default(false);
            $table->string('agent')->nullable(); // Person who posts the job
            $table->timestamp('date')->nullable();
            $table->string('source')->nullable();
            $table->string('candidate_name')->nullable();
            $table->string('candidate_first_name')->nullable();
            $table->string('candidate_last_name')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->string('address_line_1')->nullable();
            $table->string('area')->nullable();
            $table->string('city')->nullable();
            $table->string('partial_post_code')->nullable();
            $table->string('full_post_code')->nullable();
            $table->string('nationality')->nullable();
            $table->string('gender')->nullable();
            $table->date('dob')->nullable();
            $table->integer('age')->nullable();
            $table->boolean('right_to_work')->default(false);
            $table->boolean('driving_licence')->default(false);
            $table->string('languages_spoken')->nullable();
            
            // Additional CV parsing fields
            $table->text('summary')->nullable();
            $table->json('skills')->nullable();
            $table->json('experience')->nullable();
            $table->json('education')->nullable();
            $table->json('certifications')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('github')->nullable();
            $table->string('current_organization')->nullable();
            $table->string('position_title')->nullable();
            $table->string('total_experience')->nullable();
            $table->string('current_salary')->nullable();
            $table->string('salary_expectation')->nullable();
            $table->integer('notice_period_days')->nullable();
            $table->date('available_from')->nullable();
            $table->boolean('willing_to_relocate')->default(false);
            
            // File information
            $table->string('file_name')->nullable();
            $table->string('file_path')->nullable();
            $table->json('parsed_fields')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('parsed_cvs');
    }
}
