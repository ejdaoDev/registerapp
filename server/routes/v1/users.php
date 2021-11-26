<?php

use Illuminate\Support\Facades\Route;

Route::resource('user', App\Http\Controllers\Security\UserController::class)->only(['index','store','update','destroy']);
Route::get('user/get-deleted-users', [App\Http\Controllers\Security\UserController::class, 'getDeletedUsers']);
Route::get('user/restore-user/{id}', [App\Http\Controllers\Security\UserController::class, 'RestoreUser']);
Route::get('user/restore-all-users', [App\Http\Controllers\Security\UserController::class, 'RestoreAllUsers']);
