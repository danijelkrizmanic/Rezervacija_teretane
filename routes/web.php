<?php

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function(){
    Route::resource('rooms', \App\Http\Controllers\RoomController::class);
    Route::resource('termins', \App\Http\Controllers\TerminController::class);
    Route::resource('reservations', \App\Http\Controllers\ReservationController::class);
});

Route::middleware('role:admin')->group(function () {
    Route::resource('users', \App\Http\Controllers\UserController::class);
});

Route::view('/register', 'auth.register')
    ->middleware('guest');
Route::post('/register', \App\Http\Controllers\Auth\Register::class)
    ->middleware('guest');

Route::view('/login', 'auth.login')
    ->middleware('guest')
    ->name('login');
Route::post('/login', \App\Http\Controllers\Auth\Login::class)
    ->middleware('guest');

Route:: post('/logout', \App\Http\Controllers\Auth\Logout::class)
    ->middleware('auth');

