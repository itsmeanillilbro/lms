<?php

use App\Http\Controllers\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/login', [BookController::class, 'login'] );
Route::post('/logout',[BookController::class,'logout']);
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('books', BookController::class);
});

