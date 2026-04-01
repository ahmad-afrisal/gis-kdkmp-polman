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
        Schema::create('form_elevens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cooperation_id')->constrained('cooperations')->onDelete('cascade');
            $table->boolean('potential_partners')->nullable();
            $table->string('partnership_pattern')->nullable();
            $table->foreignId('commodity_id')->nullable()->constrained('commodities')->onDelete('cascade');
            $table->string('capacity')->nullable();
            $table->tinyInteger('partnership_status')->nullable(); // 0 belum Ada, 1 belum buka, 2 belum operasional
            $table->boolean('output')->nullable();
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
        Schema::dropIfExists('form_elevens');
    }
};
