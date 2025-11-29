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
        Schema::create('form_fives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cooperation_id')->constrained()->onDelete('cascade');
            $table->enum('branch_type', ['Sembako', 'Apotik', 'Klinik', 'Simpan Pinjam', 'Pergudangan', 'Logistik', 'Usaha Lain'])->nullable();
            $table->bigInteger('business_volume')->nullable();
            $table->bigInteger('total_assets')->nullable();
            $table->bigInteger('profit_loss')->nullable();
            $table->text('information')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_fives');
    }
};
