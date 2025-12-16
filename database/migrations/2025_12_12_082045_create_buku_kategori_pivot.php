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
        Schema::create('buku_kategori_pivot', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_bukus_id')->constrained('produk_bukus')->onDelete('cascade');
            $table->foreignId('kategori_bukus_id')->constrained('kategori_bukus')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['produk_bukus_id', 'kategori_bukus_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku_kategori_pivot');
    }
};
