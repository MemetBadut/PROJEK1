<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('table_inventori_toko_buku', function (Blueprint $table) {
            $table->unique(
                ['produk_buku_id', 'lokasi_toko_id'],
                'inventory_book_store_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::table('table_inventori_toko_buku', function (Blueprint $table) {
            $table->dropUnique('inventory_book_store_unique');
        });
    }
};
