<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TontineController;
use App\Http\Controllers\Api\TourController;
use App\Http\Controllers\Api\CotisationController;
use App\Http\Controllers\Api\NotificationController;

// Auth public
Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);

// Routes protégées
Route::middleware('auth:api')->group(function () {

    Route::get('/profile', [AuthController::class,'profile']);
    Route::post('/logout', [AuthController::class,'logout']);

    
// pour les tontines
    Route::get('/tontines', [TontineController::class, 'index']);
    Route::post('/tontines', [TontineController::class, 'store']);
    Route::get('/tontines/{id}', [TontineController::class, 'show']);
    Route::put('/tontines/{id}', [TontineController::class, 'update']);
    Route::delete('/tontines/{id}', [TontineController::class, 'destroy']);
});

