<?php

use App\Http\Controllers\AuthorBukuController;
use App\Http\Controllers\InputRatingController;
use App\Http\Controllers\ProdukBukuController;
use Illuminate\Support\Facades\Route;


Route::get('/', [ProdukBukuController::class, 'index'])->name('home');
Route::get('/buku/{slug}', [ProdukBukuController::class, 'show'])->name('detail_book');

Route::middleware('auth')->group(function () {
    Route::resource('voting_author', AuthorBukuController::class)->only(['store']);
    Route::resource('input_rating', InputRatingController::class)->only(['store']);
});
