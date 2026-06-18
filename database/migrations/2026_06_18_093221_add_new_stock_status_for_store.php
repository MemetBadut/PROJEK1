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
        Schema::table('table_inventori_toko_buku', function (Blueprint $table) {
            $table->unsignedBigInteger('stok_dipinjam')->default(0)->after('stok_tersedia');
            $table->unsignedBigInteger('stok_dipesan')->default(0)->after('stok_dipinjam');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('table_inventori_toko_buku', function (Blueprint $table) {
            $table->dropColumn(['stok_dipinjam', 'stok_dipesan']);
        });
    }
};
