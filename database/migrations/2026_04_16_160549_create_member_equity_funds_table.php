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
        Schema::create('member_equity_funds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cooperation_id')->constrained('cooperations')->onDelete('cascade');

            
            // Principal Capital (Simpanan Pokok)
            $table->decimal('principal_rate', 15, 2); // Nominal per orang
            $table->decimal('total_principal_paid', 15, 2); // Total diterima
            
            // Mandatory Capital (Simpanan Wajib)
            $table->decimal('mandatory_rate', 15, 2); // Nominal per orang
            $table->decimal('total_mandatory_paid', 15, 2); // Total diterima
            
            // Voluntary Deposits (Simpanan Sukarela) - Biasanya sifatnya kewajiban/liabilitas koperasi
            $table->decimal('total_voluntary_deposits', 15, 2)->default(0);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_equity_funds');
    }
};
