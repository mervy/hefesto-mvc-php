<?php

use HefestoMVC\controllers\DashboardController;
use HefestoMVCLibrary\Route;
use HefestoMVC\controllers\HomeController;

Route::get('/', [HomeController::class,'index']);
Route::get('/articles', [HomeController::class,'articles']);
Route::get('/articles/{id}', [HomeController::class,'articles']);