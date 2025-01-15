<?php

use App\Http\Controllers\AuthController;
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
Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'loginPage'])->name('loginPage');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout/{id}', [AuthController::class, 'logout'])->name('logout');
});
Route::middleware(['auth'])->prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::get('/{id}', [UserController::class, 'show'])->name('users.show');
    Route::post('/{id}', [UserController::class, 'delete'])->name('users.delete');
    Route::post('/{id}/reset-password', [UserController::class, 'resetPassword'])->name('users.resetPassword');
});



