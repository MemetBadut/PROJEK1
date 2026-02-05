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
        Schema::create('produk_bukus', function (Blueprint $table) {
            $table->id();
            $table->string('nama_buku');
            $table->foreignId('penulis_bukus_id')->constrained('penulis_bukus')->onDelete('cascade');
            $table->string('isbn');
            $table->foreignId('publisher_id')->constrained('publisher')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_bukus');
    }
};
