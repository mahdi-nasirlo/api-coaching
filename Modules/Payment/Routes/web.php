<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

<<<<<<< HEAD
Route::prefix('payment')->group(function () {
=======
Route::prefix('payment')->group(function() {
>>>>>>> origin/module/payment
    Route::get('/', 'PaymentController@index');
});
