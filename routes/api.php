<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TontineController;
use App\Http\Controllers\Api\MembreTontineController;
use App\Http\Controllers\Api\TourController;
use App\Http\Controllers\Api\CotisationController;
use App\Http\Controllers\Api\NotificationController;

/*AUTH PUBLIC*/

Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);

/*ROUTES PROTÉGÉES (JWT)*/

Route::middleware('auth:api')->group(function () {

/*USER*/

    Route::get('/profile', [AuthController::class,'profile']);
    Route::post('/logout', [AuthController::class,'logout']);

/*TONTINES*/

    Route::get('/tontines', [TontineController::class, 'index']);
    Route::post('/tontines', [TontineController::class, 'store']);
    Route::get('/tontines/{id}', [TontineController::class, 'show']);
    Route::put('/tontines/{id}', [TontineController::class, 'update']);
    Route::delete('/tontines/{id}', [TontineController::class, 'destroy']);

    /*MEMBRE TONTINES*/

    Route::get('/membre-tontines', [MembreTontineController::class, 'index']);
    Route::post('/membre-tontines', [MembreTontineController::class, 'store']);
    Route::get('/membre-tontines/{id}', [MembreTontineController::class, 'show']);
    Route::put('/membre-tontines/{id}', [MembreTontineController::class, 'update']);
    Route::delete('/membre-tontines/{id}', [MembreTontineController::class, 'destroy']);

    /*TOURS*/

    Route::get('/tours', [TourController::class, 'index']);
    Route::post('/tours', [TourController::class, 'store']);
    Route::get('/tours/{id}', [TourController::class, 'show']);
    Route::put('/tours/{id}', [TourController::class, 'update']);
    Route::delete('/tours/{id}', [TourController::class, 'destroy']);

    /*COTISATIONS*/
    Route::get('/cotisations', [CotisationController::class, 'index']);
    Route::post('/cotisations', [CotisationController::class, 'store']);
    Route::get('/cotisations/{id}', [CotisationController::class, 'show']);
    Route::put('/cotisations/{id}', [CotisationController::class, 'update']);
    Route::delete('/cotisations/{id}', [CotisationController::class, 'destroy']);

    // paiement
    Route::post('/cotisations/{id}/payer', [CotisationController::class, 'payer']);

    /*NOTIFICATIONS*/
    
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications', [NotificationController::class, 'store']);
    Route::get('/notifications/{id}', [NotificationController::class, 'show']);
    Route::put('/notifications/{id}', [NotificationController::class, 'update']);
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy']);

    Route::get('/mes-notifications', [NotificationController::class, 'mesNotifications']);
});