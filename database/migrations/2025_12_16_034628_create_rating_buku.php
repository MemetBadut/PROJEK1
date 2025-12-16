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
        Schema::create('rating_buku', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voters_id')->constrained('voters')->onDelete('cascade');
            $table->foreignId('produk_buku_id')->constrained('produk_bukus')->onDelete('cascade');
            $table->unsignedTinyInteger('score');
            $table->timestamps();

            $table->unique(['voters_id', 'produk_buku_id']);

            $table->index('produk_buku_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rating_buku');
    }
};
