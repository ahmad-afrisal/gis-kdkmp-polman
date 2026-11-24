<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cooperations', function (Blueprint $table) {
            $table->boolean('nib')->default(false)->after('microsite_account');
        });
    }

    public function down(): void
    {
        Schema::table('cooperations', function (Blueprint $table) {
            $table->dropColumn('nib');
        });
    }
};
