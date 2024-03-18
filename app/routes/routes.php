<?php

use app\library\routes\Route;
use app\controllers\site\HomeController;
use app\controllers\admin\HomeController as AdminHomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/admin', [AdminHomeController::class, 'index'])->name('admin.home');
// Route::get('/user/[a-z0-9]+/name/[a-z]+', [UserController::class, 'index'])->name('user');
