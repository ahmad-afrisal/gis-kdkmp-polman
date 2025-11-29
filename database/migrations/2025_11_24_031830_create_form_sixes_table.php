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
        Schema::create('form_sixes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cooperation_id')->constrained()->onDelete('cascade');
            $table->string('picture_land')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->integer('width_land')->nullable();
            $table->integer('long_land')->nullable();
            $table->string('letter_land')->nullable();
            $table->string('road_condition')->nullable();
            $table->string('asset')->nullable();
            $table->integer('distance')->nullable();
            $table->string('internet_access')->nullable();
            $table->string('water_access')->nullable();
            $table->string('electricity_access')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_sixes');
    }
};
