<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProcedureController;
use App\Http\Controllers\UserController;
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
    return view('welcome');
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
        Route::post('/logout/{id}', [AuthController::class, 'logout'])->name('logout');
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
        // Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/create', [ProcedureController::class, 'create'])->name('procedures.create');
        Route::post('/', [ProcedureController::class, 'store'])->name('procedures.store');
        // Route::get('/profile', [UserController::class, 'profile'])->name('users.profile');
        // Route::get('/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        // Route::get('/{id}', [UserController::class, 'show'])->name('users.show');
        // Route::post('/{id}', [UserController::class, 'delete'])->name('users.delete');
        // Route::put('/{id}/pass', [UserController::class, 'updatePassword'])->name('users.password.update');
        // Route::put('/{id}', [UserController::class, 'update'])->name('users.update');
        // Route::post('/{id}/reset-password', [UserController::class, 'resetPassword'])->name('users.resetPassword');
    });
});


