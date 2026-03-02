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
        Schema::create('data_voters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_buku_id')->constrained('produk_bukus')->onDelete('cascade');
            $table->unsignedBigInteger('total_voters')->default(0);
            $table->unsignedBigInteger('total_rating_sum')->default(0);
            $table->decimal('avg_rating', 4, 2)->default(0);
            $table->decimal('avg_7_days', 4, 2)->default(0);
            $table->decimal('avg_prev_7_days', 4, 2)->default(0);
            $table->decimal('avg_30_days', 4, 2)->default(0);
            $table->decimal('trend_7_days', 4, 2)->default(0);
            $table->string('trend_direction', 10)->default('flat');
            $table->decimal('recent_popularity_score', 8, 2)->default(0);
            $table->unsignedBigInteger('voters_30_days')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_voters');
    }
};
