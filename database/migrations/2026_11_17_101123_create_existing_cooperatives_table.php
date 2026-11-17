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
        Schema::create('existing_cooperatives', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->unique();
            $table->string('name');
            $table->string('legal_entity_number')->unique();
            $table->string('form_of_cooperative');
            $table->string('type_of_cooperative');
            $table->string('management_model');
            $table->foreignId('cooperative_status_id')->constrained('cooperative_statuses')->onDelete('cascade');
            $table->foreignId('business_activity_id')->constrained('business_activities')->onDelete('cascade');
            $table->string('cooperative_group');
            $table->foreignId('district_id')->constrained('districts')->onDelete('cascade');
            $table->foreignId('village_id')->constrained('villages')->onDelete('cascade');
            $table->text('address');
            $table->string('postal_code');
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->integer('number_of_members');
            $table->string('chairperson_name')->nullable();
            $table->string('secretary_name')->nullable();
            $table->string('treasurer_name')->nullable();
            $table->string('vice_chairperson_membership_name')->nullable();
            $table->string('vice_chairperson_business_operations_name')->nullable();
            $table->string('head_supervisory_board_name')->nullable();
            $table->string('member_supervisory_board_i_name')->nullable();
            $table->string('member_supervisory_board_ii_name')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('existing_cooperatives');
    }
};
