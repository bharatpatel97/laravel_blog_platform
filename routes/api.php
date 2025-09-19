<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\PostController;

// ---------- AUTH ----------
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// ---------- POSTS ----------
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/posts', [PostController::class, 'index']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::get('/posts/{post}', [PostController::class, 'show']);
    Route::put('/posts/{post}', [PostController::class, 'update']);
    Route::delete('/posts/{post}', [PostController::class, 'destroy']);
});


// ---------- POSTS ----------
// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('/posts', [PostController::class, 'index']);
//     Route::post('/posts', [PostController::class, 'store']);
//     Route::get('/posts/{post}', [PostController::class, 'show']);
//     Route::put('/posts/{post}', [PostController::class, 'update']);
//     Route::delete('/posts/{post}', [PostController::class, 'destroy']);
// });
