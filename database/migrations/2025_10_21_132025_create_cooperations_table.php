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
        Schema::create('cooperations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('legal_entity_number')->nullable();
            $table->date('date_legal_entity_number')->nullable();
            $table->text('full_address');
            $table->foreignId('village_id')->constrained()->onDelete('cascade');
            $table->foreignId('bussiness_assistant_id')->constrained()->onDelete('cascade');
            $table->string('latitude')->nullable();
            $table->string('longtitude')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->integer('principal_saving');
            $table->integer('mandatory_saving');
            $table->integer('subdomain');
            $table->boolean('grocery_outlet');
            $table->boolean('village_pharmacy_outlet');
            $table->boolean('coopeative_office_outlet');
            $table->boolean('savings_and_loan_outlet');
            $table->boolean('village_clinic_outlet');
            $table->boolean('cold_storage_outlet');
            $table->boolean('logistics_outlet');
            $table->boolean('fertilize_outlet');
            $table->boolean('lpg_base_outlet');
            $table->boolean('postal_agent_outlet');
            $table->boolean('smart_agent_outlet');
            $table->boolean('microsite_account');
            $table->string('leader_name')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cooperations');
    }
};
