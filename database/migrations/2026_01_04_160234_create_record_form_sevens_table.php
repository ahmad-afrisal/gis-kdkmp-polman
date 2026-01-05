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
        Schema::create('record_form_sevens', function (Blueprint $table) {
            $table->id();
            $table->string('periode'); // contoh: 2025-01, 2025-Q1
            $table->foreignId('cooperation_id')->constrained('cooperations')->onDelete('cascade');
            $table->integer('number_of_member');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('record_form_sevens');
    }
};
