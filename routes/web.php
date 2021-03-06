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
use App\Http\Controllers\Segment\Admin\Dictionary\Bank\BankController;
use App\Http\Controllers\Segment\Admin\Dictionary\Bank\QuestionController;
use App\Http\Controllers\Segment\Admin\Dictionary\Bank\BankConfigController;
use App\Http\Controllers\Segment\Admin\Dictionary\Bank\BankConfigGradeCategoryController;
use App\Http\Controllers\Segment\Admin\Dictionary\Bank\BankConfigMeasuringLvlController;
use App\Http\Controllers\Segment\Admin\Dictionary\Bank\BankConfigCompetencyTypeController;
use App\Http\Controllers\Segment\Admin\Dictionary\Bank\BankConfigSkillSetController;
use App\Http\Controllers\Segment\Admin\Dictionary\Bank\BankConfigScaleLvlController;
use App\Http\Controllers\Segment\Admin\Dictionary\Bank\BankConfigCompetencyTypeSetController;
use App\Http\Controllers\Segment\Admin\Dictionary\Bank\JobGroup\BankJobGroupController;
use App\Http\Controllers\Segment\Admin\Dictionary\Bank\Items\BankItemsController;
use App\Http\Controllers\Segment\Admin\Dictionary\Bank\JobGroup\Score\BankJobGroupScoreController;
use App\Http\Controllers\Segment\Pengguna\Dashboard\PenggunaDashboardPenggunaController;
use App\Http\Controllers\Segment\Admin\Dictionary\Bank\Items\Score\BankItemsScoreController;
use App\Http\Controllers\Segment\Pengguna\PenilaianScore\PenilaianScoreController;
use App\Http\Controllers\Segment\Penyelia\PenyeliaController;
use App\Http\Controllers\Segment\Admin\Setting\Agency\AgencyController;
use App\Http\Controllers\Segment\Pelaporan\PelaporanController;
use App\Http\Controllers\Penyelaras\PenyelarasController;

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware(['auth'])->name('logout');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');
Route::get('/dashboard/pengguna', [PenggunaDashboardPenggunaController::class, 'index']);

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
        //start collection
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
        //end collection

        Route::prefix('/bank')->group(function () {
            Route::prefix('/penilaian')->group(function () {
                Route::get('/', [BankController::class, 'index'])->name('bank.penilaian.index');
                Route::get('/list', [BankController::class, 'penilaian_list']);
                Route::post('/tambah-kemaskini', [BankController::class, 'penilaian_tambah']);
                Route::post('/get-record', [BankController::class, 'penilaian_get_record']);
                Route::post('/activate', [BankController::class, 'penilaian_activate']);
                Route::post('/delete', [BankController::class, 'penilaian_delete']);
                Route::post('/publish', [BankController::class,'publish_penilaian']);
                Route::post('/copy',[BankController::class,'copy_penilaiaan']);

                Route::get('/config/{penilaian_id}', [BankConfigController::class, 'index']);
                Route::prefix('/config')->group(function () {
                    //Grade Category
                    Route::prefix('/grade-category')->group(function () {
                        Route::get('/list/{penilaian_id}', [BankConfigGradeCategoryController::class, 'grade_category_list']);
                        Route::post('/tambah-kemaskini', [BankConfigGradeCategoryController::class, 'grade_category_tambah']);
                        Route::post('/get-record', [BankConfigGradeCategoryController::class, 'grade_category_get_record']);
                        Route::post('/activate', [BankConfigGradeCategoryController::class, 'grade_category_activate']);
                        Route::post('/delete', [BankConfigGradeCategoryController::class, 'grade_category_delete']);
                    });

                    Route::prefix('/measuring-level')->group(function () {
                        Route::get('/', [BankConfigMeasuringLvlController::class, 'index']);
                        Route::get('/list/{penilaian_id}', [BankConfigMeasuringLvlController::class, 'measuring_lvl_list']);
                        Route::post('/tambah-kemaskini', [BankConfigMeasuringLvlController::class, 'measuring_lvl_tambah']);
                        Route::post('/get-record', [BankConfigMeasuringLvlController::class, 'measuring_lvl_get_record']);
                        Route::post('/activate', [BankConfigMeasuringLvlController::class, 'measuring_lvl_activate']);
                        Route::post('/delete', [BankConfigMeasuringLvlController::class, 'measuring_lvl_delete']);
                    });

                    Route::prefix('/setting')->group(function () {
                        //Skill Set For Scale Level
                        Route::prefix('/scale-skill-set')->group(function () {
                            Route::get('/list/{penilaian_id}', [BankConfigSkillSetController::class, 'skill_set_list']);
                            Route::post('/tambah-kemaskini', [BankConfigSkillSetController::class, 'skill_set_tambah']);
                            Route::post('/get-record', [BankConfigSkillSetController::class, 'skill_set_get_record']);
                            Route::post('/activate', [BankConfigSkillSetController::class, 'skill_set_activate']);
                            Route::post('/delete', [BankConfigSkillSetController::class, 'skill_set_delete']);
                        });

                        //Competency Type
                        Route::prefix('/competency-type')->group(function () {
                            Route::get('/list/{penilaian_id}', [BankConfigCompetencyTypeController::class, 'competency_type_list']);
                            Route::post('/tambah-kemaskini', [BankConfigCompetencyTypeController::class, 'competency_type_tambah']);
                            Route::post('/get-record', [BankConfigCompetencyTypeController::class, 'competency_type_get_record']);
                            Route::post('/activate', [BankConfigCompetencyTypeController::class, 'competency_type_activate']);
                            Route::post('/delete', [BankConfigCompetencyTypeController::class, 'competency_type_delete']);
                        });
                    });

                    Route::prefix('/scale-level')->group(function () {
                        Route::get('/', [BankConfigScaleLvlController::class, 'index']);
                        Route::get('/list/{penilaian_id}', [BankConfigScaleLvlController::class, 'scale_level_list']);
                        Route::post('/tambah-kemaskini', [BankConfigScaleLvlController::class, 'scale_level_tambah']);
                        Route::post('/get-record', [BankConfigScaleLvlController::class, 'scale_level_get_record']);
                        Route::post('/activate', [BankConfigScaleLvlController::class, 'scale_level_activate']);
                        Route::post('/delete', [BankConfigScaleLvlController::class, 'scale_level_delete']);

                        Route::prefix('/set')->group(function () {
                            Route::post('/list', [BankConfigScaleLvlController::class, 'scale_level_set_list']);
                            Route::post('/tambah-kemaskini', [BankConfigScaleLvlController::class, 'scale_level_set_tambah']);
                            Route::post('/get-record', [BankConfigScaleLvlController::class, 'scale_level_set_get_record']);
                            Route::post('/activate', [BankConfigScaleLvlController::class, 'scale_level_set_activate']);
                            Route::post('/delete', [BankConfigScaleLvlController::class, 'scale_level_set_delete']);
                        });
                    });

                    Route::prefix('/competency-type-set')->group(function () {
                        Route::get('/', [BankConfigCompetencyTypeSetController::class, 'index']);
                        Route::get('/list/{penilaian_id}', [BankConfigCompetencyTypeSetController::class, 'competency_type_set_list']);
                        Route::post('/tambah-kemaskini', [BankConfigCompetencyTypeSetController::class, 'competency_type_set_tambah']);
                        Route::post('/get-record', [BankConfigCompetencyTypeSetController::class, 'competency_type_set_get_record']);
                        Route::post('/activate', [BankConfigCompetencyTypeSetController::class, 'competency_type_set_activate']);
                        Route::post('/delete', [BankConfigCompetencyTypeSetController::class, 'competency_type_set_delete']);
                    });

                    //Bahagian Rubmin
                    Route::get('/config/items/{penilaian_id}', [BankConfigController::class, 'index']);
                    Route::prefix('/items')->group(function () {
                        Route::get('/{id}', [BankItemsController::class, 'index']);
                        Route::get('/datalist/item/{id}', [BankItemsController::class, 'bank_item_list']);
                        Route::post('/save/item', [BankItemsController::class,'bank_item_save']);
                        Route::post('/get-record/item', [BankItemsController::class,'bank_item_get_record']);
                        Route::post('/active/item',[BankItemsController::class,'bank_col_activate']);
                        Route::post('/delete/item',[BankItemsController::class,'bank_col_delete']);
                        Route::get('/datalist/colitems',[BankItemsController::class,'item_cols_list']);

                        Route::prefix('/question')->group(function () {
                            Route::get('/list/{item_id}', [BankItemsController::class, 'bank_item_question_list']);
                            Route::post('/tambah-kemaskini', [BankItemsController::class, 'bank_item_question_tambah']);
                            Route::post('/get-record', [BankItemsController::class,'bank_item_question_get_record']);
                            Route::post('/activate', [BankItemsController::class, 'bank_item_question_activate']);
                            Route::post('/delete',[BankItemsController::class,'bank_item_question_delete']);
                        });

                        Route::get('/scores/{item_id}',[BankItemsScoreController::class,'index']);
                        Route::post('/scores/save/items',[BankItemsScoreController::class,'save_scores']);
                    });

                    Route::get('/items/question/{item_id}', [BankConfigController::class, 'index']);

                    //End Bahagian Rubmin
                });
                Route::get('/job-group/{penilaian_id}', [BankJobGroupController::class, 'index']);
                Route::prefix('/job-group')->group(function () {
                    Route::get('/list/{penilaian_id}', [BankJobGroupController::class, 'job_group_list']);
                    Route::get('/insert-update/{penilaian_id}', [BankJobGroupController::class, 'job_group_insert_update_page']);
                    Route::post('/insert-update/get-jurusan-item', [BankJobGroupController::class, 'job_group_jurusan_items']);
                    Route::post('/insert-update/tambah-kemaskini', [BankJobGroupController::class, 'job_group_insert_update_tambah']);
                    Route::post('/activate', [BankJobGroupController::class, 'job_group_activate']);
                    Route::post('/delete', [BankJobGroupController::class, 'job_group_delete']);
                    Route::get('/insert-update/{penilaian_id}/{job_group_id}', [BankJobGroupController::class, 'job_group_insert_update_page']);

                    Route::get('/score/{job_group_id}', [BankJobGroupScoreController::class, 'index']);
                    Route::prefix('/score')->group(function () {
                        Route::post('/tambah-kemaskini', [BankJobGroupScoreController::class, 'job_group_score_tambah']);
                    });
                });
            });
        });
        // end bank
    });

    // Route::get('/admin/dictionary/bank/item/col-datalist', [QuestionController::class, 'load_col_items']);


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
        //Agency
        Route::prefix('/agency')->group(function () {
            Route::get('/', [AgencyController::class, 'index']);
            Route::get('/list', [AgencyController::class, 'load_agencies_tree']);
            Route::post('/save', [AgencyController::class, 'save_agency']);
            Route::post('/active', [AgencyController::class, 'active_agency']);
            Route::post('/delete', [AgencyController::class, 'delete_agency']);
            Route::post('/get', [AgencyController::class, 'get_agency']);
            Route::get('/reload_lookup', [AgencyController::class, 'load_agencies_lookup']);
            Route::get('/load_penyelaras/{id}', [AgencyController::class, 'list_penyelaras']);
        });
    });
});

//Pengguna
Route::prefix('/pengguna')->group(function () {
    Route::prefix('/penyelia')->group(function () {
        Route::post('/list', [PenggunaDashboardPenggunaController::class, 'getPenyelia']);
        Route::post('/tambah-kemaskini', [PenggunaDashboardPenggunaController::class, 'tambah_kemaskini']);
    });

    Route::prefix('/job-group')->group(function () {
        Route::post('/list', [PenggunaDashboardPenggunaController::class, 'getJobGroup']);
        Route::post('/tambah-kemaskini', [PenggunaDashboardPenggunaController::class, 'tambah_kemaskini_job_group']);
    });

    Route::get('/penilaian/score/{penilaian_id}', [PenilaianScoreController::class, 'index']);
    Route::get('/penilaian/keputusan/{penilaian_id}', [PenilaianScoreController::class, 'score_keputusan']);
    Route::prefix('/penilaian')->group(function () {
        Route::prefix('/score')->group(function () {
            Route::post('/update-score', [PenilaianScoreController::class, 'update_score']);
            Route::post('/kemaskini-score', [PenilaianScoreController::class, 'kemaskini_score']);
            Route::post('/hantar-score', [PenilaianScoreController::class, 'hantar_score']);
        });

        Route::prefix('/keputusan')->group(function () {
            Route::prefix('/score')->group(function () {

            });
        });
    });

    Route::prefix('/penyelaras')->group(function() {
        Route::get('/',[PenyelarasController::class, 'load_main_page']);
        Route::get('/list',[PenyelarasController::class, 'load_all_penilaians']);
        Route::post('/add',[PenyelarasController::class,'add_penyelaras']);
        Route::post('/delete',[PenyelarasController::class,'delete_penyelaras']);
        Route::post('/detail',[PenyelarasController::class,'load_list_caw']);
        Route::get('/info',[PenyelarasController::class,'load_list_staff']);
    });
});

//Penyelia
Route::get('/penyelia/pengesahan/result/{user_id}/{penilaian_id}/{trigger}', [PenyeliaController::class, 'pengesahan_result']);

Route::prefix('/penyelia')->group(function () {
    Route::prefix('/pengesahan')->group(function () {
        Route::get('/new', [PenyeliaController::class, 'index']);
        Route::get('/new/with-penyelia/{penilaian_id}', [PenyeliaController::class, 'result_keputusan_with_penyelia']);
        Route::post('/new/with-penyelia-send', [PenyeliaController::class, 'simpan_keputusan_penyelia']);
        Route::get('/accept-all', [PenyeliaController::class, 'penyelia_accept_all']);
    });
});

//Pelaporan
Route::prefix('/pelaporan')->group(function () {
    Route::get('/', [PelaporanController::class, 'index']);

    //basic tablecount
    Route::get('/analisis-jurang-standard/{trigger}', [PelaporanController::class, 'analisis_jurang_standard']);
    Route::post('/analisis-jurang-standard/{trigger}', [PelaporanController::class, 'analisis_jurang_standard']);
    Route::post('/analisis-jurang-standard-search', [PelaporanController::class, 'analisis_jurang_standard_search']);

    //graph tablecount
    Route::get('/analisis-jurang-standard-graph/{trigger}', [PelaporanController::class, 'analisis_jurang_standard_graph']);
    Route::post('/analisis-jurang-standard-graph/{trigger}', [PelaporanController::class, 'analisis_jurang_standard_graph']);
});
//Common Controller
Route::prefix('/common')->group(function () {
    Route::prefix('/user')->group(function () {
        Route::get('/carian', [CommonController::class, 'pengguna_carian']);
        Route::post('/maklumat', [CommonController::class, 'pengguna_maklumat']);
    });
    Route::post('/get-listing', [CommonController::class, 'listing']);
    // Agency common search -Rubmin
    Route::prefix('/agency')->group(function() {
        Route::get('/search',[CommonController::class, 'search_agency']);
    });
});

require __DIR__.'/auth.php';
