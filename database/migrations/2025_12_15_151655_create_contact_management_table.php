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
        Schema::create('contact_management', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cooperation_id')->constrained()->onDelete('cascade');
            $table->string('leader_name')->nullable();
            $table->string('leader_phone_number')->nullable();
            $table->string('name_of_deputy_member')->nullable();
            $table->string('deputy_member_phone_number')->nullable();
            $table->string('name_of_deputy_business')->nullable();
            $table->string('deputy_business_phone_number')->nullable();
            $table->string('name_of_secretary')->nullable();
            $table->string('secretary_phone_number')->nullable();
            $table->string('name_of_treasurer')->nullable();
            $table->string('treasurer_phone_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_management');
    }
};
