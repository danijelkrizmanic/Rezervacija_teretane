<?php

use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TerminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::middleware('auth')->group(function (): void {
    Route::resource('termins', TerminController::class)
        ->only(['index'])
        ->middleware('role:user|trainer|admin');

    Route::resource('termins', TerminController::class)
        ->only(['store', 'show', 'edit', 'update', 'destroy'])
        ->middleware('role:trainer|admin');

    Route::resource('rooms', RoomController::class)
        ->only(['index', 'store', 'edit', 'update', 'destroy'])
        ->middleware('role:trainer|admin');

    Route::resource('reservations', ReservationController::class)
        ->only(['index', 'store', 'destroy'])
        ->middleware('role:user');

    Route::put('reservations/{reservation}', [ReservationController::class, 'update'])
        ->name('reservations.update')
        ->middleware('role:trainer|admin');

    Route::resource('users', UserController::class)
        ->only(['index', 'edit', 'update'])
        ->middleware('role:admin');

    Route::post('/logout', Logout::class);
});

Route::view('/register', 'auth.register')
    ->middleware('guest');
Route::post('/register', Register::class)
    ->middleware('guest');

Route::view('/login', 'auth.login')
    ->middleware('guest')
    ->name('login');
Route::post('/login', Login::class)
    ->middleware('guest');
