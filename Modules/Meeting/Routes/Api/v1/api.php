<?php

use Illuminate\Support\Facades\Route;
use Modules\Meeting\Http\Controllers\CoachController;
use Modules\Meeting\Http\Controllers\MeetingController;
use Modules\Meeting\Http\Controllers\PayMeetingController;

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
    Route::get('/{uuid}', [CoachController::class, 'show'])->name('show');

    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/{coach}', [CoachController::class, 'update'])->name('update');
        Route::post('/', [CoachController::class, 'store'])->name('store');

    });

});

Route::prefix('meeting')->name('meeting.')->group(function () {

    Route::get('/coach/{coach}', [MeetingController::class, 'index'])->name('getAll');

    Route::get('/coach/{coach:uuid}/getAppointmentDay', [MeetingController::class, "getAppointmentDay"])->name('get-appointment-day');

    Route::get('coach/{coach:uuid}/getAppointmentDayTime', [MeetingController::class, 'getAppointmentDayTime'])->name('get-appointment-day-time');

    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/create', [MeetingController::class, 'store'])->name('create');

        Route::get('/toggleStatus/{meeting}', [MeetingController::class, 'toggleStatus'])->name('toggleStatus');

        Route::prefix('/reserve')->name('reserve.')->group(callback: function () {

            Route::get('/{meeting}/pay', [PayMeetingController::class, 'payment'])->name('pay');

        });

    });

    Route::get('/{transaction:verify_code}/reserve', [PayMeetingController::class, 'reserved'])->name('reserve.verify');

});
