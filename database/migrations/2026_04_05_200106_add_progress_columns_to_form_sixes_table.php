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
        Schema::table('form_sixes', function (Blueprint $table) {
            // Menambahkan kolom boolean dengan default false
            $table->boolean('is_build')->nullable()->default(false)->after('id'); 

            
            // Menambahkan kolom persentase (integer atau decimal)
            $table->integer('persentase')->nullable()->default(0)->after('is_build');
            $table->text('progress')->nullable()->after('persentase');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_sixes', function (Blueprint $table) {
            $table->dropColumn(['is_build', 'progress' , 'persentase']);
        });
    }
};
