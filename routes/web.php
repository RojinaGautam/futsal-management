<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AcademyController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ParkingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StaffAttendanceController;

// Public routes
Route::get('/', function () {
    return redirect()->route('login.form');
});

// Route for the login page
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');

// Route to handle login submission
Route::post('/login', [LoginController::class, 'login'])->name('login');

// Route to handle logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected routes - any authenticated user can access
Route::middleware(['auth'])->group(function () {
    // Dashboard access for all authenticated users
    Route::get('/admin', function () {
        return view('backend.index');
    });

    // Later we can add role-specific middleware for specific features
    // Example:
    // Route::middleware(['role:super-admin'])->group(function () {
    //     // Super admin only features
    // });

    // Academy routes
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

    // Parking routes
    Route::get('/parkings', [ParkingController::class, 'index'])->name('parkings.index');
    Route::post('/parkings/store', [ParkingController::class, 'store'])->name('parkings.store');
    Route::get('/parkings/data', [ParkingController::class, 'getParkingData'])->name('parkings.data');
    Route::get('/parkings/{id}', [ParkingController::class, 'show'])->name('parkings.show');
    Route::patch('/parkings/update/{id}', [ParkingController::class, 'update'])->name('parkings.update');
    Route::delete('/parkings/{id}', [ParkingController::class, 'destroy'])->name('parkings.destroy');
    Route::put('/parkings/{id}/payment', [ParkingController::class, 'updatePayment'])->name('parkings.updatePayment');

    // User routes
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/data', [UserController::class, 'getUsers'])->name('users.data');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/unlock', [UserController::class, 'unlock'])->name('users.unlock');

    // Staff attendance routes
    Route::get('/staff-attendance', function () {
        return view('backend.attendance.staff_attendance'); // Adjust the path as needed
    })->name('staff.attendance');

    Route::get('/staff-attendance/{user_id}/{date}', [StaffAttendanceController::class, 'getAttendanceStatus'])->name('staff.attendance.status');
    Route::post('/staff-attendance/check-in', [StaffAttendanceController::class, 'checkIn'])->name('staff.attendance.checkIn');
    Route::post('/staff-attendance/check-out', [StaffAttendanceController::class, 'checkOut'])->name('staff.attendance.checkOut');
});

