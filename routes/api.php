<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TontineController;
use App\Http\Controllers\Api\TourController;
use App\Http\Controllers\Api\CotisationController;
use App\Http\Controllers\Api\NotificationController;


Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);

Route::middleware('auth:api')->group(function () {

    Route::get('/profile', [AuthController::class,'profile']);

    Route::post('/logout', [AuthController::class,'logout']);

});

Route::middleware('auth:api')->group(function () {

    Route::apiResource('tontines', TontineController::class);

    Route::apiResource('tours', TourController::class);

    Route::apiResource('cotisations', CotisationController::class);

    Route::apiResource('notifications', NotificationController::class);

});