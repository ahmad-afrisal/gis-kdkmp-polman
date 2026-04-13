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
        Schema::create('online_attendances', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel BA/User
            $table->foreignId('bussiness_assistant_id')->constrained('bussiness_assistants')->onDelete('cascade');
            
            // Data Waktu & Tanggal
            // Menggunakan date dan time secara terpisah memudahkan filter laporan
            $table->date('date'); 
            $table->time('check_in');
            
            // Detail Kegiatan
            $table->text('activity'); 
            
            // Tambahan opsional: Lokasi GPS
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('picture')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('online_attendances');
    }
};
