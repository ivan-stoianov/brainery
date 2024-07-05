<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\Members\MembersController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware('admin.guest')->group(function () {
    Route::get('auth/login', [LoginController::class, 'show'])->name('auth.login');
    Route::post('auth/login', [LoginController::class, 'store']);
});

Route::prefix('admin')->middleware('admin.auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::post('sidebar-toggle', [HomeController::class, 'toggleSidebar'])->name('sidebar.toggle');
    Route::post('auth/logout', [LoginController::class, 'logout'])->name('auth.logout');

    Route::get('members', [MembersController::class, 'index'])->name('members.index');
});
