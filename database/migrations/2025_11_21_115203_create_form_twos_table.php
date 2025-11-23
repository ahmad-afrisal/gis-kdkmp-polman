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
        Schema::create('form_twos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cooperation_id')->constrained()->onDelete('cascade');
            $table->text('bussiness_plan')->nullable();
            $table->boolean('basic_necessities_exist')->nullable();
            $table->boolean('basic_necessities_running')->nullable();
            $table->boolean('savings_and_loan_exist')->nullable();
            $table->boolean('savings_and_loan_running')->nullable();
            $table->boolean('pharmacy_exist')->nullable();
            $table->boolean('pharmacy_running')->nullable();
            $table->boolean('clinic_exist')->nullable();
            $table->boolean('clinic_running')->nullable();
            $table->boolean('logistics_exist')->nullable();
            $table->boolean('logistics_running')->nullable();
            $table->boolean('storage_exist')->nullable();
            $table->boolean('storage_running')->nullable();
            $table->boolean('other_businesses_exist')->nullable();
            $table->boolean('other_businesses_running')->nullable();
            $table->text('information')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_twos');
    }
};
