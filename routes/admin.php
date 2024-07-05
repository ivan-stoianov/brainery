<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\HomeController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    Route::get('auth/login', [LoginController::class, 'show'])->name('auth.login');
    Route::post('auth/login', [LoginController::class, 'store']);

    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::post('sidebar-toggle', [HomeController::class, 'toggleSidebar'])->name('sidebar.toggle');
});
