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
        Schema::create('rating_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_voters_id')->constrained('data_voters')->onDelete('cascade');
            $table->foreignId('produk_bukus_id')->constrained('produk_bukus')->onDelete('cascade');
            $table->unsignedTinyInteger('score');
            $table->timestamps();

            $table->unique(['data_voters_id', 'produk_bukus_id']);

            $table->index('produk_bukus_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rating_users');
    }
};
