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
        Schema::create('rating_daily_summary', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_buku_id')->constrained('produk_bukus')->onDelete('cascade');
            $table->date('date')->nullable();
            $table->integer('total_votes');
            $table->decimal('total_sums');
            $table->unique(['produk_buku_id', 'date']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rating_daily_summary');
    }
};
