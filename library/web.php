<?php

use HefestoMVC\controllers\DashboardController;
use HefestoMVCLibrary\Route;
use HefestoMVC\controllers\HomeController;

Route::get('/', [HomeController::class,'index']);
Route::get('/show/{title}/{id}', [HomeController::class,'show']);
Route::get('/articles/{id}', [HomeController::class,'articles']);