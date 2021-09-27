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

    Route::prefix('/catgrade')->group(function () {
        //Year List: First Step
        Route::get('/year', [CategoryGradeController::class, 'year_index']);
        Route::get('/year-list', [CategoryGradeController::class, 'kategori_grade_year_list']);
        Route::get('/{year_id}', [CategoryGradeController::class, 'index']);

        //Kategori List: Second Step
        Route::get('/list', [CategoryGradeController::class, 'kategori_grade_list']);
        Route::post('/tambah', [CategoryGradeController::class, 'kategori_grade_tambah']);
        Route::post('/aktif', [CategoryGradeController::class, 'kategori_grade_aktif']);
        Route::post('/delete', [CategoryGradeController::class, 'kategori_grade_delete']);
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
