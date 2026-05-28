<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('rooms', \App\Http\Controllers\RoomController::class);
Route::resource('termins', \App\Http\Controllers\TerminController::class);
