<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — Shared / Auth
|--------------------------------------------------------------------------
| Public and authentication routes. Admin and patient routes are in
| routes/admin.php and routes/patient.php respectively.
|
*/

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('reservations.create');
    }

    return redirect()->route('login');
})->name('home');

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

Route::middleware('setlocale')->group(function () {

    Route::get('/lang/{lang}', function ($lang) {
        session(['lang' => $lang]);

        return redirect()->back();
    });

    Route::prefix('auth')->group(function () {
        Route::get('/login', [AuthController::class, 'loginPage'])->name('loginPage');
        Route::get('/register', [AuthController::class, 'registerPage'])->name('registerPage');
        Route::post('/register', [AuthController::class, 'register'])->name('register');
        Route::post('/login', [AuthController::class, 'login'])->name('login');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });

    // Own profile accessible to all authenticated users
    Route::middleware('auth')->prefix('users')->group(function () {
        Route::get('/profile', [UserController::class, 'profile'])->name('users.profile');
    });
});
