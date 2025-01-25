<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProcedureController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReservationNoteController;
use App\Http\Controllers\ReservationProcedureController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkingDayController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('reservations.create'); // Redirect to home if authenticated
    } else {
        return redirect()->route('login'); // Redirect to login if not authenticated
    }
});
Route::group(['middleware' => 'setlocale'], function () {

    // Language change routes (optional, if you want to switch languages via URL)
    Route::get('/lang/{lang}', function ($lang) {
        // You can redirect to a page after changing the language
        session(['lang' => $lang]);  // Store the language in session
        return redirect()->back();
    });
    Route::prefix('auth')->group(function () {
        Route::get('/login', [AuthController::class, 'loginPage'])->name('loginPage');
        Route::get('/register', [AuthController::class, 'registerPage'])->name('registerPage');
        Route::post('/register', [AuthController::class, 'register'])->name('register');
        Route::post('/login', [AuthController::class, 'login'])->name('login');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
    Route::middleware(['auth'])->prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/profile', [UserController::class, 'profile'])->name('users.profile');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::get('/{id}', [UserController::class, 'show'])->name('users.show');
        Route::post('/{id}', [UserController::class, 'delete'])->name('users.delete');
        Route::put('/{id}/pass', [UserController::class, 'updatePassword'])->name('users.password.update');
        Route::put('/{id}', [UserController::class, 'update'])->name('users.update');
        Route::post('/{id}/reset-password', [UserController::class, 'resetPassword'])->name('users.resetPassword');
    });
    Route::middleware(['auth'])->prefix('procedures')->group(function () {
        Route::get('/', [ProcedureController::class, 'index'])->name('procedures.index');
        Route::get('/create', [ProcedureController::class, 'create'])->name('procedures.create');
        Route::post('/', [ProcedureController::class, 'store'])->name('procedures.store');
        Route::get('/{id}/edit', [ProcedureController::class, 'edit'])->name('procedures.edit');
        Route::get('/{id}', [ProcedureController::class, 'show'])->name('procedures.show');
        Route::delete('/{id}', [ProcedureController::class, 'delete'])->name('procedures.delete');
    });

    Route::middleware(['auth'])->prefix('reservations')->group(function () {
        Route::get('/', [ReservationController::class, 'index'])->name('reservations.index');
        Route::get('/history', [ReservationController::class, 'history'])->name('reservations.history');
        Route::get('/create', [ReservationController::class, 'create'])->name('reservations.create');
        Route::get('/{id}/apply', [ReservationController::class, 'applyPage'])->name('reservations.applyPage');
        Route::get('/{id}', [ReservationController::class, 'show'])->name('reservations.show');

        Route::post('/', [ReservationController::class, 'store'])->name('reservations.store');
        Route::put('/', [ReservationController::class, 'updateProcedures'])->name('reservations.update');
        Route::put('/{id}/paid', [ReservationController::class, 'paid'])->name('reservations.paid');
        Route::post('/store', [ReservationNoteController::class, 'store'])->name('reservationNotes.store');

    });

    Route::middleware(['auth'])->prefix('reservation_procedures')->group(function () {
        Route::post('/', [ReservationProcedureController::class, 'store'])->name('reservations_pro.store');

    });

    Route::middleware(['auth'])->prefix('working-days')->group(function () {
        Route::get('/', [WorkingDayController::class, 'index'])->name('working-days.index');
        Route::get('/slatesNumber', [WorkingDayController::class, 'slates'])->name('working-days.slatesNumber');
        Route::get('/create', [WorkingDayController::class, 'create'])->name('working-days.create');
        Route::post('/', [WorkingDayController::class, 'store'])->name('working-days.store');

    });

});


