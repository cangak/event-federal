<?php

use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\AdminParticipantController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [ParticipantController::class, 'create'])
    ->name('participants.create');

Route::post('/register', [ParticipantController::class, 'store'])
    ->name('participants.store');

Route::get('/register/success/{token}', [ParticipantController::class, 'success'])
    ->name('participants.success');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/admin/participants', [AdminParticipantController::class, 'index'])
        ->name('admin.participants.index');

    Route::get('/admin/participants/scan', [AdminParticipantController::class, 'scan'])
        ->name('admin.participants.scan');

    Route::get('/admin/participants/print-bibs', [AdminParticipantController::class, 'printBibs'])
        ->name('admin.participants.print-bibs');

    Route::get('/admin/participants/{participant}/bib', [AdminParticipantController::class, 'printBib'])
        ->name('admin.participants.print-bib');

    Route::post('/admin/participants/check-in', [AdminParticipantController::class, 'checkIn'])
        ->name('admin.participants.check-in');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
