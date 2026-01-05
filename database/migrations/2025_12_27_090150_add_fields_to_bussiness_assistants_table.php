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
        Schema::table('bussiness_assistants', function (Blueprint $table) {
            $table->text('address')->nullable()->after('slug');
            $table->string('phone_number')->nullable()->after('address');
            $table->date('date_of_birth')->nullable()->after('phone_number');
            $table->string('picture')->nullable()->after('date_of_birth'); // path foto
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bussiness_assistants', function (Blueprint $table) {
            $table->dropColumn([
                'address',
                'phone_number',
                'date_of_birth',
                'picture'
            ]);
        });
    }
};
