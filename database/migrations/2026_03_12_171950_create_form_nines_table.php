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
        Schema::create('form_nines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cooperation_id')->constrained('cooperations')->onDelete('cascade');
            $table->integer('outlet_status')->nullable(); // 0 : Belum ada, 1 : Belum Buka, 2, Operasional
            $table->integer('number_of_employees_2025')->nullable(); 
            $table->integer('number_of_employees_2026')->nullable(); 
            $table->boolean('outlet_operations_guide')->nullable();
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
        Schema::dropIfExists('form_nines');
    }
};
