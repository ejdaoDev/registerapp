<?php

use Illuminate\Support\Facades\Route;

Route::get('user', [App\Http\Controllers\Security\UserController::class, 'get']);
Route::post('user', [App\Http\Controllers\Security\UserController::class, 'create']);
Route::put('user/{id}', [App\Http\Controllers\Security\UserController::class, 'update']);
Route::delete('user/{id}', [App\Http\Controllers\Security\UserController::class, 'delete']);
