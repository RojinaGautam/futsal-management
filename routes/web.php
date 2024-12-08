<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

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
