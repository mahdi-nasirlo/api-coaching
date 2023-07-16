<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;


Route::name('auth.')
    ->prefix('auth/')
    ->group(function () {
        
        Route::post('register', [AuthController::class, 'createUser'])->name('auth.register');
        Route::post('login', [AuthController::class, 'loginUser'])->name('auth.login');

    });
