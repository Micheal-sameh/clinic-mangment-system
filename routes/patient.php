<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Patient Routes
|--------------------------------------------------------------------------
| Self-service routes for authenticated patients.
| Patients can view their own profile, their reservations, and history.
|
*/

Route::middleware(['auth', 'setlocale'])->prefix('patient')->name('patient.')->group(function () {

    // Patient's own profile
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');

    // Patient's own reservation history (read-only)
    Route::get('/history', [\App\Http\Controllers\ReservationController::class, 'history'])->name('history');
});
