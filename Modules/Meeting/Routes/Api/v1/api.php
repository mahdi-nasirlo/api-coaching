<?php

use Illuminate\Support\Facades\Route;
use Modules\Meeting\Http\Controllers\CoachController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('coach')->name('coach.')->group(function () {

    Route::get('/', [CoachController::class, 'index'])->name('index');
    Route::get('/{user_name}', [CoachController::class, 'show'])->name('show');

    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/{coach:uuid}', [CoachController::class, 'update'])->name('update');
        Route::post('/', [CoachController::class, 'store'])->name('store');

    });

});
