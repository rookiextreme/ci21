<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Segment\Dashboard\DashboardController;
use App\Http\Controllers\Segment\Admin\Users\UserController;
use App\Http\Controllers\Main\CommonController;
use App\Http\Controllers\Segment\Admin\Dictionary\MeasuringLvl\ColMeasuringLvlController;
use App\Http\Controllers\Segment\Admin\Dictionary\GradeCategory\ColGradeCategoryController;
use App\Http\Controllers\Segment\Admin\Setting\Grade\GradeController;

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

    //Dictionary Collection
    Route::prefix('/dictionary')->group(function () {
        Route::prefix('/collection')->group(function () {
            //Measuring Lvl
            Route::prefix('/measuring-level')->group(function () {
                Route::get('/', [ColMeasuringLvlController::class, 'index']);
                Route::get('/list', [ColMeasuringLvlController::class, 'measuring_lvl_list']);
                Route::post('/tambah-kemaskini', [ColMeasuringLvlController::class, 'measuring_lvl_tambah']);
                Route::post('/get-record', [ColMeasuringLvlController::class, 'measuring_lvl_get_record']);
                Route::post('/activate', [ColMeasuringLvlController::class, 'measuring_lvl_activate']);
                Route::post('/delete', [ColMeasuringLvlController::class, 'measuring_lvl_delete']);
            });

            //Grade Category
            Route::prefix('/grade-category')->group(function () {
                Route::get('/', [ColGradeCategoryController::class, 'index']);
                Route::get('/list', [ColGradeCategoryController::class, 'grade_category_list']);
                Route::post('/tambah-kemaskini', [ColGradeCategoryController::class, 'grade_category_tambah']);
                Route::post('/get-record', [ColGradeCategoryController::class, 'grade_category_get_record']);
                Route::post('/activate', [ColGradeCategoryController::class, 'grade_category_activate']);
                Route::post('/delete', [ColGradeCategoryController::class, 'grade_category_delete']);
            });
        });
    });

    //Regular Grade Listing
    Route::prefix('/setting')->group(function () {
        //Grade
        Route::prefix('/grade')->group(function () {
            Route::get('/', [GradeController::class, 'index']);
            Route::get('/list', [GradeController::class, 'grade_list']);
            Route::post('/tambah-kemaskini', [GradeController::class, 'grade_tambah']);
            Route::post('/get-record', [GradeController::class, 'grade_get_record']);
            Route::post('/activate', [GradeController::class, 'grade_activate']);
            Route::post('/delete', [GradeController::class, 'grade_delete']);
        });
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
