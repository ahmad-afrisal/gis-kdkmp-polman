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
        Schema::create('form_eights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cooperation_id')->constrained('cooperations')->onDelete('cascade');
            $table->boolean('land_readiness')->nullable();
            $table->integer('store_development')->nullable(); // 0 : Belum, 1 : Selesai, 2, Tidak Terbangun
            $table->boolean('vehicle')->nullable();
            $table->boolean('table_and_chair')->nullable();
            $table->boolean('display_case')->nullable();
            $table->boolean('computer')->nullable();
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
        Schema::dropIfExists('form_eights');
    }
};
