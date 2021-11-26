<?php

use Illuminate\Support\Facades\Route;

Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);
Route::get('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);
Route::get('refresh', [App\Http\Controllers\Auth\LoginController::class, 'refresh']);
