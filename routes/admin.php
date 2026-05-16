<?php

use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\ProcedureController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReservationNoteController;
use App\Http\Controllers\ReservationProcedureController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkingDayController;
use App\Rules\CheckActiveDayRule;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
| Routes accessible only to admin/staff roles.
| All routes in this file are protected by auth + setlocale middleware.
|
*/

Route::middleware(['auth', 'setlocale'])->group(function () {

    // ── Staff / User management ───────────────────────────────────
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/', [UserController::class, 'store'])->name('users.store');
    });

    // ── Patient management (admin view) ───────────────────────────
    Route::prefix('patients')->group(function () {
        Route::get('/', [UserController::class, 'patientsIndex'])->name('patients.index');
        Route::get('/create', [UserController::class, 'create'])->name('patients.create');
        Route::post('/', [UserController::class, 'store'])->name('patients.store');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::get('/{id}', [UserController::class, 'show'])->name('users.show');
        Route::post('/{id}', [UserController::class, 'delete'])->name('users.delete');
        Route::put('/{id}/pass', [UserController::class, 'updatePassword'])->name('users.password.update');
        Route::put('/{id}/change-status', [UserController::class, 'changeStatus'])->name('users.changeStatus');
        Route::put('/{id}', [UserController::class, 'update'])->name('users.update');
        Route::post('/{id}/reset-password', [UserController::class, 'resetPassword'])->name('users.resetPassword');
    });

    // ── Procedures ────────────────────────────────────────────────
    Route::prefix('procedures')->group(function () {
        Route::get('/', [ProcedureController::class, 'index'])->name('procedures.index');
        Route::get('/create', [ProcedureController::class, 'create'])->name('procedures.create');
        Route::post('/', [ProcedureController::class, 'store'])->name('procedures.store');
        Route::get('/{id}/edit', [ProcedureController::class, 'edit'])->name('procedures.edit');
        Route::put('/{id}', [ProcedureController::class, 'update'])->name('procedures.update');
        Route::get('/{id}', [ProcedureController::class, 'show'])->name('procedures.show');
        Route::delete('/{id}', [ProcedureController::class, 'delete'])->name('procedures.delete');
    });

    // ── Reservations ──────────────────────────────────────────────
    Route::prefix('reservations')->group(function () {
        Route::get('/', [ReservationController::class, 'index'])->name('reservations.index');
        Route::get('/history', [ReservationController::class, 'history'])->name('reservations.history');
        Route::get('/create', [ReservationController::class, 'create'])->name('reservations.create');
        Route::get('/{id}/apply', [ReservationController::class, 'applyPage'])->name('reservations.applyPage');
        Route::get('/{id}', [ReservationController::class, 'show'])->name('reservations.show');
        Route::get('/{id}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');

        Route::post('/', [ReservationController::class, 'store'])->name('reservations.store');
        Route::put('/{id}', [ReservationController::class, 'update'])->name('reservations.update');
        Route::put('/{id}/paid', [ReservationController::class, 'paid'])->name('reservations.paid');
        Route::put('/cancel/{id}', [ReservationController::class, 'destroy'])->name('reservations.cancel');

        Route::post('/store', [ReservationNoteController::class, 'store'])->name('reservationNotes.store');
    });

    Route::prefix('reservation_procedures')->group(function () {
        Route::post('/', [ReservationProcedureController::class, 'store'])->name('reservations_pro.store');
    });

    // ── Diagnoses ─────────────────────────────────────────────────
    Route::prefix('diagnoses')->group(function () {
        Route::post('/', [DiagnosisController::class, 'store'])->name('diagnoses.store');
        Route::delete('/{id}', [DiagnosisController::class, 'destroy'])->name('diagnoses.destroy');
    });

    // ── Prescriptions ─────────────────────────────────────────────
    Route::prefix('prescriptions')->group(function () {
        Route::post('/', [PrescriptionController::class, 'store'])->name('prescriptions.store');
        Route::delete('/{id}', [PrescriptionController::class, 'destroy'])->name('prescriptions.destroy');
    });

    // ── Working Days ──────────────────────────────────────────────
    Route::prefix('working-days')->group(function () {
        Route::get('/', [WorkingDayController::class, 'index'])->name('working-days.index');
        Route::get('/slatesNumber', [WorkingDayController::class, 'slates'])->name('working-days.slatesNumber');
        Route::get('/create', [WorkingDayController::class, 'create'])->name('working-days.create');
        Route::put('/', [WorkingDayController::class, 'update'])->name('working-days.update');
        Route::get('/{id}/active', [WorkingDayController::class, 'active'])->name('working-days.active');
        Route::get('/doctor/{doctorId}', [WorkingDayController::class, 'index'])->name('working-days.doctor')->where('doctorId', '[0-9]+');
        Route::get('check-active-date', function () {
            $data = [
                'date' => request('date'),
                'doctor_id' => request('doctor_id'),
            ];
            $validator = Validator::make($data, [
                'date' => ['required', new CheckActiveDayRule(request('doctor_id'))],
                'doctor_id' => 'required|exists:doctors,id',
            ]);

            return response()->json(['is_active' => $validator->fails() ? 0 : 1]);
        })->withoutMiddleware(['auth']);
    });

    // ── Reports ───────────────────────────────────────────────────
    Route::prefix('reports')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('reports.index');
    });

    // ── Settings ──────────────────────────────────────────────────
    Route::prefix('settings')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('settings.index');
        Route::put('/', [SettingController::class, 'update'])->name('settings.update');
    });

    // ── Doctors ───────────────────────────────────────────────────
    Route::prefix('doctors')->group(function () {
        Route::get('/', [DoctorController::class, 'index'])->name('doctors.index');
        Route::get('/create', [DoctorController::class, 'create'])->name('doctors.create');
        Route::post('/', [DoctorController::class, 'store'])->name('doctors.store');
        Route::get('/{id}', [DoctorController::class, 'show'])->name('doctors.show');
        Route::get('/{id}/edit', [DoctorController::class, 'edit'])->name('doctors.edit');
        Route::put('/{id}', [DoctorController::class, 'update'])->name('doctors.update');
        Route::delete('/{id}', [DoctorController::class, 'destroy'])->name('doctors.destroy');
    });
});
