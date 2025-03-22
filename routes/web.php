<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AcademyController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ParkingController;

// Route for the home page
Route::get('/', function () {
    return redirect()->route('login.form');
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

    Route::prefix('bookings')->group(function () {
        Route::get('/', [BookingController::class, 'index'])->name('bookings.index');
        Route::get('/data', [BookingController::class, 'getData'])->name('bookings.data');
        Route::post('/store', [BookingController::class, 'store'])->name('bookings.store');
        Route::get('/{id}', [BookingController::class, 'show'])->name('bookings.show');
        Route::patch('/update/{id}', [BookingController::class, 'update'])->name('bookings.update');
        Route::delete('/{id}', [BookingController::class, 'destroy'])->name('bookings.destroy');
        Route::put('/{id}/payment', [BookingController::class, 'updatePayment'])->name('bookings.updatePayment');
    });

});

// Parking routes protected by auth middleware
Route::middleware('auth')->group(function () {
    Route::prefix('parkings')->group(function () {
        Route::get('/', [ParkingController::class, 'index'])->name('parkings.index');
        Route::post('/store', [ParkingController::class, 'store'])->name('parkings.store');
        Route::get('/data', [ParkingController::class, 'getParkingData'])->name('parkings.data');
        Route::get('/{id}', [ParkingController::class, 'show'])->name('parkings.show');
        Route::patch('/update/{id}', [ParkingController::class, 'update'])->name('parkings.update');
        Route::delete('/{id}', [ParkingController::class, 'destroy'])->name('parkings.destroy');
        Route::put('/{id}/payment', [ParkingController::class, 'updatePayment'])->name('parkings.updatePayment'); // Route for payment
    });
});

Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
Route::get('/attendance/fetch', [AttendanceController::class, 'fetchAttendance'])->name('attendance.fetch');
Route::post('/attendance/submit', [AttendanceController::class, 'submitAttendance'])->name('attendance.store');
Route::post('/attendance/submit', [AttendanceController::class, 'submitAttendance'])->name('attendance.submit');
Route::get('/attendance/data', [AttendanceController::class, 'getAttendanceData'])->name('attendance.data');