<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;

// Halaman Publik
Route::get('/', [RegistrationController::class, 'create'])->name('register.create');
Route::post('/register', [RegistrationController::class, 'store'])->name('register.store');
Route::get('/ticket/{ticket_code}', [RegistrationController::class, 'show'])->name('ticket.show');

// Otentikasi Panitia
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute Khusus Panitia (Dilindungi Middleware)
Route::middleware(['panitia'])->group(function () {
    Route::get('/dashboard', [AttendanceController::class, 'dashboard'])->name('attendance.dashboard');
    Route::get('/dashboard/export', [AttendanceController::class, 'export'])->name('attendance.export');
    Route::get('/scan', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/check-in', [AttendanceController::class, 'checkIn'])->name('attendance.checkin');
});