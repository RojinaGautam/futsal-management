<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AcademyController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AttendanceController;

// Route for the home page
Route::get('/', function () {
    return view('frontend.index');
});

// Route for the login page
Route::get('/login', function () {
    return view('backend.login');
})->name('login.form');

// Route to handle login submission
Route::post('/login', [LoginController::class, 'login'])->name('login');

// Route for the admin dashboard
Route::get('/admin', function () {
    return view('backend.index');
})->middleware('auth');

// Route to handle logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

// Academy routes protected by auth middleware
Route::middleware('auth')->group(function () {
    Route::get('/academy', [AcademyController::class, 'index'])->name('academy.index');
    Route::post('/academy/store', [AcademyController::class, 'store'])->name('academy.store');
    Route::get('/academy/data', [AcademyController::class, 'getAcademyData'])->name('academy.data');
    Route::get('/academy/{id}', [AcademyController::class, 'show'])->name('academy.show');
    Route::match(['patch', 'post'], '/academy/update/{id}', [AcademyController::class, 'update'])->name('academy.update');
    Route::delete('/academy/{id}', [AcademyController::class, 'destroy']);
    Route::put('/academy/{id}/payment', [AcademyController::class, 'updatePayment'])->name('academy.updatePayment');
});

// Route for parking
Route::get('/parking', function () {
    return view('backend.parking');
});

Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
Route::get('/attendance/fetch', [AttendanceController::class, 'fetchAttendance'])->name('attendance.fetch');
Route::post('/attendance/submit', [AttendanceController::class, 'submitAttendance'])->name('attendance.store');
Route::post('/attendance/submit', [AttendanceController::class, 'submitAttendance'])->name('attendance.submit');
Route::get('/attendance/data', [AttendanceController::class, 'getAttendanceData'])->name('attendance.data');
