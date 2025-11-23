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
        Schema::create('form_threes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cooperation_id')->constrained()->onDelete('cascade');
            $table->string('financing_partner')->nullable();
            $table->boolean('bh_deed')->nullable();
            $table->boolean('cooperative_nik')->nullable();
            $table->boolean('cooperative_bank_account')->nullable();
            $table->boolean('npwp')->nullable();
            $table->boolean('nib')->nullable();
            $table->boolean('business_activity_plan')->nullable();
            $table->boolean('capex')->nullable();
            $table->boolean('opex')->nullable();
            $table->boolean('other_equipment')->nullable();
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
        Schema::dropIfExists('form_threes');
    }
};
