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
        Schema::create('companies', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('contact')->nullable();
        $table->string('email')->nullable();
        $table->string('postal_code')->nullable();
        $table->text('address')->nullable();
        $table->string('city')->nullable();
        $table->string('state')->nullable();
        $table->string('country')->nullable();
        $table->string('contractpname')->nullable();
        $table->string('company_description')->nullable();
        $table->string('head_office')->nullable();
        $table->string('no_of_employes')->nullable();
        $table->string('no_of_offices')->nullable();
        $table->string('industry')->nullable();
        $table->string('facebook')->nullable();
        $table->string('linkedln')->nullable();
        $table->string('instagram')->nullable();
        $table->string('twitter')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
