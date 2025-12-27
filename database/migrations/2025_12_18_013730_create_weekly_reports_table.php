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
        Schema::create('weekly_reports', function (Blueprint $table) {
            $table->id();
            $table->integer('simkopdes');
            $table->integer('nib');
            $table->integer('npwp');
            $table->integer('bank_account');
            $table->integer('business_activity_plan');
            $table->integer('financing_proposal');
            $table->integer('number_of_member');
            $table->integer('ods');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_reports');
    }
};
