<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\SignupController;

Route::post('/login', LoginController::class)->name('login');

Route::post('/logout', LogoutController::class)->name('logout')
    ->middleware('auth:sanctum');

Route::post('/signup', SignupController::class)->name('signup');