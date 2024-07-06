<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\Member\ProfileController;
use App\Http\Controllers\Admin\Members\MembersController;
use App\Http\Controllers\Admin\Settings\SettingsController;
use Illuminate\Support\Facades\Route;

Route::middleware('admin.guest')->group(function () {
    Route::get('auth/login', [LoginController::class, 'show'])->name('auth.login');
    Route::post('auth/login', [LoginController::class, 'store']);
});

Route::middleware('admin.auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::post('sidebar-toggle', [HomeController::class, 'toggleSidebar'])->name('sidebar.toggle');
    Route::post('auth/logout', [LoginController::class, 'logout'])->name('auth.logout');

    Route::get('members', [MembersController::class, 'index'])->name('members.index');

    Route::prefix('member/{member}')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('member.show');
    });

    Route::prefix('settings')->name('settings.')->group(function() {
        Route::get('/', [SettingsController::class, 'edit'])->name('edit');
        Route::put('/', [SettingsController::class, 'update'])->name('update');
    });
});
