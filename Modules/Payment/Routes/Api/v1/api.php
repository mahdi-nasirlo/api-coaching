<?php

use Illuminate\Support\Facades\Route;
use Modules\Payment\Http\Controllers\MeetingPayController;

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

Route::middleware('api:sanctum')->prefix("payment")->name('payment.')->group(function () {

    Route::get('/meeting/{meeting}', [MeetingPayController::class, 'payment'])->name('meeting');

    Route::get('/meeting/reserve/{meeting}', [MeetingPayController::class, 'store'])->name('meeting.reserve');

});
