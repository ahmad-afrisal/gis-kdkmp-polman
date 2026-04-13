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
        Schema::create('form_tens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cooperation_id')->constrained('cooperations')->onDelete('cascade');
            $table->boolean('profile_update')->nullable();
            $table->boolean('village_potential')->nullable();
            $table->boolean('grocery_outlet')->nullable();
            $table->boolean('pharmacy_outlet')->nullable();
            $table->boolean('warehousing_outlet')->nullable();
            $table->boolean('clinic_outlet')->nullable();
            $table->boolean('logistics_outlet')->nullable();
            $table->boolean('usp_outlet')->nullable();
            $table->boolean('other_businesses_outlet')->nullable();
            $table->boolean('rat')->nullable();
            $table->integer('initial_membership')->nullable(); 
            $table->integer('addition_of_members')->nullable();
            $table->text('problem')->nullable();
            $table->text('information')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_tens');
    }
};
