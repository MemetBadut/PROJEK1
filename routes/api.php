<?php

use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RatingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'loginApi']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logoutApi']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/login', [AuthController::class, 'loginApi']);
    Route::post('/logout', [AuthController::class, 'logoutApi']);

    Route::apiResource('books', BookController::class)->only('store', 'update', 'delete');
    Route::apiResource('ratings', RatingController::class)->only('store', 'update', 'delete');
    Route::apiResource('authors', AuthorController::class)->only('store', 'update', 'delete');
});

Route::apiResource('books', BookController::class)->only('index', 'show');
Route::apiResource('ratings', RatingController::class)->only('index', 'show');
Route::apiResource('authors', AuthorController::class)->only('index', 'show');


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
