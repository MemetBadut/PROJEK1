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
        Schema::create('table_inventori_toko_buku', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_buku_id')
                ->constrained('produk_bukus')
                ->cascadeOnDelete();
            $table->foreignId('lokasi_toko_id')
                ->constrained('lokasi_toko')
                ->cascadeOnDelete();

            $table->unsignedBigInteger('stok_total')->default(0);
            $table->unsignedBigInteger('stok_tersedia')->default(0);
            $table->string('kode_rak', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_inventori_toko_buku');
    }
};
