<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('existing_cooperative_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('existing_cooperative_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('path');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('existing_cooperative_images');
    }
};
