<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Segment\Dashboard\DashboardController;
use App\Http\Controllers\Segment\Admin\Users\UserController;
use App\Http\Controllers\Main\CommonController;
use App\Http\Controllers\Segment\Admin\Setting\CategoryGradeController;

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

//Admin
Route::prefix('/admin')->group(function () {
    Route::prefix('/user')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/list', [UserController::class, 'pengguna_list']);
        Route::post('/tambah', [UserController::class, 'pengguna_tambah']);
        Route::post('/aktif', [UserController::class, 'pengguna_aktif']);
        Route::post('/delete', [UserController::class, 'pengguna_delete']);
        Route::post('/get-one-pengguna', [UserController::class, 'get_one_user']);
        Route::post('/role-update', [UserController::class, 'pengguna_role_update']);
    });
});

//Common Controller
Route::prefix('/common')->group(function () {
    Route::prefix('/user')->group(function () {
        Route::get('/carian', [CommonController::class, 'pengguna_carian']);
        Route::post('/maklumat', [CommonController::class, 'pengguna_maklumat']);
    });
    Route::post('/get-listing', [CommonController::class, 'listing']);
});

require __DIR__.'/auth.php';
