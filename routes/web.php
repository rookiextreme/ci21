<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Segment\Dashboard\DashboardController;
use App\Http\Controllers\Segment\Admin\Users\UserController;
use App\Http\Controllers\Main\CommonController;
use App\Http\Controllers\Segment\Admin\Dictionary\MeasuringLvl\ColMeasuringLvlController;
use App\Http\Controllers\Segment\Admin\Dictionary\GradeCategory\ColGradeCategoryController;
use App\Http\Controllers\Segment\Admin\Setting\Grade\GradeController;
use App\Http\Controllers\Segment\Admin\Dictionary\Setting\Skillset\ColSkillsetController;
use App\Http\Controllers\Segment\Admin\Dictionary\ScaleLvl\ColScaleLvlController;
use App\Http\Controllers\Segment\Admin\Dictionary\Setting\CompetencyType\ColCompetencyTypeController;
use App\Http\Controllers\Segment\Admin\Dictionary\CompetencyTypeSet\ColCompetencyTypeSetController;
use App\Http\Controllers\Segment\Admin\Dictionary\Collection\ColController;
use App\Http\Controllers\Segment\Admin\Dictionary\Collection\ColQuesController;

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
            //Collection
            Route::prefix('/listing')->group(function () {
                Route::get('/', [ColController::class, 'index']);
                Route::get('/list', [ColController::class, 'dict_list']);
                Route::post('/tambah-kemaskini', [ColController::class, 'dict_tambah']);
                Route::post('/get-record', [ColController::class, 'dict_get_record']);
                Route::post('/activate', [ColController::class, 'dict_activate']);
                Route::post('/delete', [ColController::class, 'dict_delete']);

                Route::prefix('/ques')->group(function () {
                    Route::post('/list', [ColQuesController::class, 'dict_ques_list']);
                    Route::post('/tambah-kemaskini', [ColQuesController::class, 'dict_ques_tambah']);
                    Route::post('/get-record', [ColQuesController::class, 'dict_ques_get_record']);
                    Route::post('/activate', [ColQuesController::class, 'dict_ques_activate']);
                    Route::post('/delete', [ColQuesController::class, 'dict_ques_delete']);
                });
            });

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

            Route::prefix('/competency-type-set')->group(function () {
                Route::get('/', [ColCompetencyTypeSetController::class, 'index']);
                Route::get('/list', [ColCompetencyTypeSetController::class, 'competency_type_set_list']);
                Route::post('/tambah-kemaskini', [ColCompetencyTypeSetController::class, 'competency_type_set_tambah']);
                Route::post('/get-record', [ColCompetencyTypeSetController::class, 'competency_type_set_get_record']);
                Route::post('/activate', [ColCompetencyTypeSetController::class, 'competency_type_set_activate']);
                Route::post('/delete', [ColCompetencyTypeSetController::class, 'competency_type_set_delete']);
            });

            Route::prefix('/scale-level')->group(function () {
                Route::get('/', [ColScaleLvlController::class, 'index']);
                Route::get('/list', [ColScaleLvlController::class, 'scale_level_list']);
                Route::post('/tambah-kemaskini', [ColScaleLvlController::class, 'scale_level_tambah']);
                Route::post('/get-record', [ColScaleLvlController::class, 'scale_level_get_record']);
                Route::post('/activate', [ColScaleLvlController::class, 'scale_level_activate']);
                Route::post('/delete', [ColScaleLvlController::class, 'scale_level_delete']);

                Route::prefix('/set')->group(function () {
                    Route::post('/list', [ColScaleLvlController::class, 'scale_level_set_list']);
                    Route::post('/tambah-kemaskini', [ColScaleLvlController::class, 'scale_level_set_tambah']);
                    Route::post('/get-record', [ColScaleLvlController::class, 'scale_level_set_get_record']);
                    Route::post('/activate', [ColScaleLvlController::class, 'scale_level_set_activate']);
                    Route::post('/delete', [ColScaleLvlController::class, 'scale_level_set_delete']);
                });
            });

            Route::prefix('/score-card')->group(function () {

            });

            Route::prefix('/setting')->group(function () {
                //Skill Set For Scale Level
                Route::prefix('/scale-skill-set')->group(function () {
                    Route::get('/', [ColSkillsetController::class, 'index']);
                    Route::get('/list', [ColSkillsetController::class, 'skill_set_list']);
                    Route::post('/tambah-kemaskini', [ColSkillsetController::class, 'skill_set_tambah']);
                    Route::post('/get-record', [ColSkillsetController::class, 'skill_set_get_record']);
                    Route::post('/activate', [ColSkillsetController::class, 'skill_set_activate']);
                    Route::post('/delete', [ColSkillsetController::class, 'skill_set_delete']);
                });

                //Competency Type
                Route::prefix('/competency-type')->group(function () {
                    Route::get('/', [ColCompetencyTypeController::class, 'index']);
                    Route::get('/list', [ColCompetencyTypeController::class, 'competency_type_list']);
                    Route::post('/tambah-kemaskini', [ColCompetencyTypeController::class, 'competency_type_tambah']);
                    Route::post('/get-record', [ColCompetencyTypeController::class, 'competency_type_get_record']);
                    Route::post('/activate', [ColCompetencyTypeController::class, 'competency_type_activate']);
                    Route::post('/delete', [ColCompetencyTypeController::class, 'competency_type_delete']);
                });
            });
        });
    });

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
