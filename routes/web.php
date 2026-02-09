<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorBukuController;
use App\Http\Controllers\ProdukBukuController;
use App\Http\Controllers\InputRatingController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/', [ProdukBukuController::class, 'index'])->name('home');
Route::get('/buku/{buku:slug}', [ProdukBukuController::class, 'show'])->name('detail_book');

Route::middleware('auth')->group(function (): void {
    Route::get('/voting', [InputRatingController::class, 'index'])->name('voting.index');
    Route::post('/voting', [InputRatingController::class, 'store'])->name('voting.store');

    Route::get('/author', [AuthorBukuController::class, 'index'])->name('author.index');
    Route::get('/author/{id}', [AuthorBukuController::class, 'store'])->name('author.store');
});
