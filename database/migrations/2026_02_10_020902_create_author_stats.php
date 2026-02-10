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
        Schema::create('author_stats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('author_id');
            $table->unsignedBigInteger('total_books');
            $table->unsignedBigInteger('total_voters');
            $table->unsignedBigInteger('voters_gt_5');            $table->decimal('rating_30d', 3, 2);
            $table->decimal('avg_rating', 3, 2);
            $table->decimal('rating_prev_30d', 3, 2)->nullable();
            $table->decimal('popularity_score', 8, 2)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('author_stats');
    }
};
