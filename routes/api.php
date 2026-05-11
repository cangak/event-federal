<?php

use App\Http\Controllers\AdminParticipantController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])
    ->name('api.login');

Route::middleware('api.token')->group(function () {
    Route::post('/check-in', [AdminParticipantController::class, 'checkIn'])
        ->name('api.check-in');
});
