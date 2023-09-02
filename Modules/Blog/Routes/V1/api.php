<?php


use Illuminate\Support\Facades\Route;
use Modules\Blog\Http\Controllers\CategoryController;

Route::prefix("/category")->name("category.")->group(function () {

    Route::get("/getAll", [CategoryController::class, "index"]);

});
