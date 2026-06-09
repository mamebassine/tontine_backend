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

    // User
    Route::get('/profile', [AuthController::class,'profile']);
    Route::post('/logout', [AuthController::class,'logout']);

    // Resources
    Route::apiResource('tontines', TontineController::class);
    Route::apiResource('tours', TourController::class);
    Route::apiResource('cotisations', CotisationController::class);
    Route::apiResource('notifications', NotificationController::class);
});