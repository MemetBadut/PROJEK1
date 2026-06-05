<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('data_voters', function (Blueprint $table): void {
            $table->unique('produk_buku_id', 'data_voters_produk_buku_id_unique');
        });
    }

    public function down(): void
    {
        Schema::table('data_voters', function (Blueprint $table): void {
            $table->dropUnique('data_voters_produk_buku_id_unique');
        });
    }
};
