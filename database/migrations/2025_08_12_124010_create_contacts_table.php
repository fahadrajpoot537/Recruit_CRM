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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('title')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('phone')->nullable();

            // Social Links
            $table->string('facebook_profile_url')->nullable();
            $table->string('twitter_profile_url')->nullable();
            $table->string('linkedin_profile_url')->nullable();
            $table->string('xing_profile_url')->nullable();

            // Stage (e.g., Lead, Prospect, Customer)
            $table->string('stage')->nullable();

            // Location Info
            $table->string('locality')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->text('full_address')->nullable();
             $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
