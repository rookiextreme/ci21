<?php
namespace App\Http\Controllers\Segment\Admin\Dictionary\Bank;

use App\Http\Controllers\Controller;
use App\Models\Penilaian\DictBank\Set\DictBankSet;
use App\Models\Regular\Year;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use DateTime;

use App\Models\Penilaian\Setting\Competency\DictBankCompetencyType;
use App\Models\Penilaian\Grade\DictBankGradeCategory;
use App\Models\Penilaian\Grade\DictBankGrade;
use App\Models\Penilaian\Setting\Measuringlvl\DictBankMeasuringlvl;
use App\Models\Penilaian\Setting\Scalelvl\DictBankScaleLvl;
use App\Models\Penilaian\Setting\Scalelvl\DictBankScaleLvlsSkillset;
use App\Models\Penilaian\Setting\Scalelvl\DictBankScaleLvlsSet;
use App\Models\Penilaian\Setting\Scalelvl\DictBankCompetencyTypesScaleLvl;
use App\Models\Penilaian\DictBank\Set\DictBankSetsItem;
use App\Models\Penilaian\DictBank\Question\DictBankSetsCompetenciesQuestion;
use App\Models\Penilaian\DictBank\Score\DictBankSetsItemsScoresSetsGrade;
use App\Models\Penilaian\Jobgroup\Set\DictBankJobgroupSet;
use App\Models\Penilaian\Jobgroup\Set\DictBankJobgroupSetsItem;
use App\Models\Penilaian\Jobgroup\Score\DictBankJobgroupSetsItemsScoresSetsGrade;


class BankController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $tahun = Year::where('year', '<=', date('Y'))->get();
        return view('segment.admin.dictionarybank.penilaian.index', [
            'year' => $tahun
        ]);
    }

    public function penilaian_list(){
        $model = DictBankSet::where('delete_id', 0)->get();

        return DataTables::of($model)
            ->setRowAttr([
                'data-bank-set-id' => function($data) {
                    return $data->id;
                },
                'data-bank-set-flag-id' => function($data) {
                    return $data->flag;
                },
            ])
            ->addColumn('name', function($data){
                return strtoupper($data->title);
            })
            ->addColumn('tkh_mula', function($data){
                return strtoupper($data->tkh_mula);
            })
            ->addColumn('tkh_tamat', function($data){
                return strtoupper($data->tkh_tamat);
            })
            ->addColumn('publish', function($data){
                if($data->flag_publish == 1) {
                    $now = new DateTime('NOW');
                    $start = new DateTime($data->tkh_mula);
                    $end = new DateTime($data->tkh_tamat);
                    if($now->getTimestamp() > $start->getTimestamp() && $now->getTimestamp() < $end->getTimestamp()) {
                        return strtoupper('AKTIF');
                    } else if($now->getTimestamp() > $end->getTimestamp()){
                        return strtoupper('TUTUP');
                    } else {
                        return strtoupper('TERBIT');
                    }
                } else {
                    return strtoupper($data->flag_publish == 0 ? 'Draf' : 'Dihantar');
                }
            })
            ->addColumn('active', function($data){
                return strtoupper($data->flag);
            })

            ->rawColumns(['active', 'action'])
            ->make(true);
    }

    public function penilaian_tambah(Request $request){
        $model = new DictBankSet();
        $process = $model->createAndUpdate($request);
        return response()->json($process);
    }

    public function penilaian_get_record(Request $request){
        $process = DictBankSet::getRecord($request->input('penilaian_id'));

        $data = [];
        if($process){
            $data = [
                'success' => 1,
                'data' => [
                    'name' => $process->title,
                    'tahun' => $process->years_id,
                    'tkh_mula' => $process->tkh_mula,
                    'tkh_tamat' => $process->tkh_tamat
                ]
            ];
        }
        return response()->json($data);
    }

    public function penilaian_activate(Request $request){
        $model = new DictBankSet;
        $process = $model->rekodActivate($request->input('penilaian_id'));

        return response()->json($process);
    }

    public function penilaian_delete(Request $request){
        $grade_id = $request->input('penilaian_id');
        $model = DictBankSet::find($grade_id);
        $model->delete_id = 1;
        if($model->save()){
            return response()->json([
                'success' => 1
            ]);
        }
    }

    public function publish_penilaian(Request $request)
    {
        $grade_id = $request->input('penilaian_id');
        $model = DictBankSet::find($grade_id);
        $itemSets = $model->dictBankSetDictBankSetsItem;
        $canPublish = false;
        $message = 'Error';

        if($itemSets->count() == 0) {
            $message = 'Tiada Koleksi Soalan Lagi';
           return response()->json([
                'success' => 0,
                'data' => [
                    'message' => $message
                ]

            ]);
        } else {

            foreach($itemSets as $item) {
                if($item->flag == 1 && $item->delete_id == 0) {
                    if(empty($item->dictBankSetsItemCompetencyTypeScaleLvl)) {
                        $message = "Tiada Jenis Kompentensi Telah Ditetapkan Pada Koleksi Soalan";
                        $canPublish = false;
                        // print_r("item id : ".$item->id.", pass : ".$canPublish." reason : Empty CompentencyTypeScaleLvl \n");

                        break;
                    } else if($item->dictBankSetsItemDictBankComQuestion->count() == 0) {
                        $message = "Tiada Soalan Telah Ditetapkan Dalam Koleksi Soalan";
                        $canPublish = false;
                        // print_r("item id : ".$item->id.", pass : ".$canPublish." reason: Empty Question \n");
                        break;
                    } else {
                        $canPublish = true;
                    }
                }
                // print_r("item id : ".$item->id.", pass : ".$canPublish." \n");
            }

            // die();

            if($canPublish) {
                $model->flag_publish = $model->flag_publish == 1 ? 0 : 1;
                if($model->save()){
                    return response()->json([
                        'success' => 1,
                        'data' => [
                            'message' => $message
                        ]
                    ]);
                } else {
                    return response()->json([
                        'success' => 2,
                        'data' => [
                            'message' => $message
                        ]
                    ]);
                }
            } else {
               return response()->json([
                    'success' => 0,
                    'data' => [
                        'message' => $message
                    ]
                ]);
// <<<<<<< HEAD
            }
        }
    }

    public function copy_penilaiaan(Request $request) {
        //$model = new DictBankSet();
        $penilaian_nama = $request->input('penilaian_nama');
        $penilaian_tahun = $request->input('penilaian_tahun');
        $penilaian_tkh_mula = $request->input('penilaian_tkh_mula');
        $penilaian_tkh_tamat = $request->input('penilaian_tkh_tamat');
        $old_penilaian_id = $request->input('penilaian_id');
        $trigger = $request->input('trigger');

        //if($trigger == 0){
        $checkDup = DictBankSet::getDuplicate($penilaian_nama);
        $model = DictBankSet::getRecord();
        $model->flag_publish = 0;
        $model->flag = 1;
        $model->delete_id = 0;
        /*}else{
            $checkDup = DictBankSet::getDuplicate($penilaian_nama, $penilaian_id);
            $model = DictBankSet::getRecord($penilaian_id);
        }*/

        if($checkDup){
            return [
                'success' => 2
            ];
        }

        $model->title = $penilaian_nama;
        $model->years_id = $penilaian_tahun;
        $model->tkh_mula = $penilaian_tkh_mula;
        $model->tkh_tamat = $penilaian_tkh_tamat;
        $model->ref_id = 0;

        if($model->save()){
            $penilaian_id = $model->id;

            //copy grade_categories and list of grades under each category
            $grade_categories_cols = DictBankGradeCategory::where('dict_bank_sets_id',$old_penilaian_id)->get();

            $grade_categories_arr = array();
            $grade_arr = array();
            foreach($grade_categories_cols as $col) {
                $mdl = new DictBankGradeCategory;
                $mdl->dict_bank_sets_id = $penilaian_id;
                $mdl->name = $col->name;
                $mdl->flag = $col->flag;
                $mdl->delete_id = $col->delete_id;

                if($mdl->save()) {
                    $id = $mdl->id;
                    $grade_categories_arr[$col->id] = $id;

                    // problem unstable
                    /*
                    if(empty($mdl->dictBankGradeCategoryGetGrade)) {
                        $mdl->loadMissing('dictBankGradeCategoryGetGrade');
                    }

                    foreach($mdl->dictBankGradeCategoryGetGrade as $grade) {
                        $childMdl = new DictBankGrade;
                        $childMdl->dict_bank_grades_categories_id = $id;
                        $childMdl->grades_id = $grade->grades_id;
                        $childMdl->flag = $grade->flag;
                        $childMdl->delete_id = $grade->delete_id;

                        if($childMdl->save()) {
                            $grade_arr[$grade->id] = $childMdl->id;
                        }
                    }
                    */

                    $dictBankGradeCategoryGetGrade = DictBankGrade::where('dict_bank_grades_categories_id',$col->id)->get();

                    foreach($dictBankGradeCategoryGetGrade as $grade) {
                        $childMdl = new DictBankGrade;
                        $childMdl->dict_bank_grades_categories_id = $id;
                        $childMdl->grades_id = $grade->grades_id;
                        $childMdl->flag = $grade->flag;
                        $childMdl->delete_id = $grade->delete_id;

                        if($childMdl->save()) {
                            $grade_arr[$grade->id] = $childMdl->id;
                        }
                    }
                }
            }

            //copy measuring_lvls
            $measuring_lvls_col = DictBankMeasuringlvl::where('dict_bank_sets_id',$old_penilaian_id)->get();

            $measuring_lvls_arr = array();
            foreach($measuring_lvls_col as $col) {
                $mdl = new DictBankMeasuringlvl;
                $mdl->dict_bank_sets_id = $penilaian_id;
                $mdl->name = $col->name;
                $mdl->flag = $col->flag;
                $mdl->delete_id = $col->delete_id;

                if($mdl->save()) {
                    $measuring_lvls_arr[$col->id] = $mdl->id;
                }

            }

            //copy compentency_types
            $compentency_types_cols = DictBankCompetencyType::where('dict_bank_sets_id',$old_penilaian_id)->get();

            $compentency_types_arr = array();

            foreach($compentency_types_cols as $col) {
                $m = new DictBankCompetencyType;
                $m->name = $col->name;
                $m->dict_bank_sets_id = $penilaian_id;
                $m->tech_discipline_flag = $col->tech_discipline_flag;
                $m->flag = $col->flag;
                $m->delete_id = $col->delete_id;

                if($m->save()) {
                    $id = $mdl->id;
                    $compentency_types_arr[$col->id] = $id;
                }
            }

            $scale_lvls_skillsets_col = DictBankScaleLvlsSkillset::where('dict_bank_sets_id',$old_penilaian_id)->get();

            $scale_lvls_skillsets_arr = array();
            foreach($scale_lvls_skillsets_col as $col) {
            $scale_lvls_skillsets_col = DictBankScaleLvlsSkillset::where('dict_bank_sets_id',$old_penilaian_id)->get();
                $mdl = new DictBankScaleLvlsSkillset;
                $mdl->dict_bank_sets_id = $penilaian_id;
                $mdl->name = $col->name;
                $mdl->flag = $col->flag;
                $mdl->delete_id = $col->delete_id;

                if($mdl->save()) {
                    $id = $mdl->id;
                    $scale_lvls_skillsets_arr[$col->id] = $id;
                }
            }

            $scale_lvls_sets_cols = DictBankScaleLvl::where('dict_bank_sets_id',$old_penilaian_id)->get();

            $scale_lvls_sets_arr = array();
            foreach($scale_lvls_sets_cols as $col) {
                $mdl = new DictBankScaleLvl;
                $mdl->dict_bank_sets_id = $penilaian_id;
                $mdl->name = $col->name;
                $mdl->flag = $col->flag;
                $mdl->delete_id = $col->delete_id;

                if($mdl->save()) {
                    $id = $mdl->id;
                    $scale_lvls_sets_arr[$col->id] = $id;

                    /*
                    if(empty($mdl->dictBankScaleLvlScaleSet)) {
                        $mdl->loadMissing('dictBankScaleLvlScaleSet');
                    }

                    foreach($mdl->dictBankScaleLvlScaleSet as $scale_set) {
                        $child = new DictBankScaleLvlsSet;
                        $child->name = $scale_set->name;
                        $child->flag = $scale_set->flag;
                        $child->delete_id = $scale_set->delete_id;
                        $child->score = $$scale_set->score;
                        $child->dict_bank_scale_lvls_id = $id;
                        $child->dict_bank_scale_lvls_skillsets_id = $scale_lvls_skillsets_arr[$scale_set->dict_bank_scale_lvls_skillsets_id];

                        $child->save();
                    }
                    */
                    $dictBankScaleLvlScaleSet = DictBankScaleLvlsSet::where('dict_bank_scale_lvls_id',$col->id)->get();
                    foreach($dictBankScaleLvlScaleSet as $scale_set) {
                        $child = new DictBankScaleLvlsSet;
                        $child->name = $scale_set->name;
                        $child->flag = $scale_set->flag;
                        $child->delete_id = $scale_set->delete_id;
                        $child->score = $scale_set->score;
                        $child->dict_bank_scale_lvls_id = $id;
                        $child->dict_bank_scale_lvls_skillsets_id = $scale_lvls_skillsets_arr[$scale_set->dict_bank_scale_lvls_skillsets_id];

                        $child->save();
                    }
                }
            }

            $competency_types_scale_lvls = DictBankCompetencyTypesScaleLvl::where('dict_bank_sets_id',$old_penilaian_id)->get();
            $competency_types_scale_lvls_arr = array();
            foreach($competency_types_scale_lvls as $col) {
                $mdl = new DictBankCompetencyTypesScaleLvl;
                $mdl->flag = $col->flag;
                $mdl->delete_id = $col->delete_id;
                $mdl->dict_bank_sets_id = $penilaian_id;
                $mdl->dict_bank_competency_types_id = $compentency_types_arr[$col->dict_bank_competency_types_id];
                $mdl->dict_bank_scale_lvls_id = $scale_lvls_sets_arr[$col->dict_bank_scale_lvls_id];

                if($mdl->save()) {
                    $id = $mdl->id;
                    $competency_types_scale_lvls_arr[$col->id] = $id;
                }
            }

            $sets_items_cols = DictBankSetsItem::where('dict_bank_sets_id',$old_penilaian_id)->get();
            $competencies_questions_arr = array();
            $sets_items_arr = array();
            $old_sets_item_arr = array();
            foreach($sets_items_cols as $col){
                $old_sets_item_arr[] = $col->id;
                $mdl = new DictBankSetsItem;
                $mdl->flag = $col->flag;
                $mdl->delete_id = $col->delete_id;
                $mdl->dict_bank_sets_id = $penilaian_id;
                $mdl->jurusan_id = $col->jurusan_id;
                $mdl->title_eng = $col->title_eng;
                $mdl->title_mal = $col->title_mal;
                $mdl->dict_bank_measuring_lvls_id = $measuring_lvls_arr[$col->dict_bank_measuring_lvls_id];
                $mdl->dict_bank_competency_types_scale_lvls_id = $competency_types_scale_lvls_arr[$col->dict_bank_competency_types_scale_lvls_id];
                $mdl->dict_bank_grades_categories_id = $grade_categories_arr[$col->dict_bank_grades_categories_id];

                if($mdl->save()) {
                    $id = $mdl->id;
                    $sets_items_arr[$col->id] = $id;
                    /*
                    if(empty($col->dictBankSetsItemDictBankComQuestion)) {
                        $mdl->loadMissing('dictBankSetsItemDictBankComQuestion');
                    }

                    foreach($col->dictBankSetsItemDictBankComQuestion as $question) {
                        $child = new DictBankSetsCompetenciesQuestion;
                        $child->dict_bank_sets_items_id = $id;
                        $child->title_eng = $question->title_eng;
                        $child->title_mal = $question->title_mal;
                        $child->flag = $question->flag;
                        $child->delete_id = $question->delete_id;

                        if($child->save()) {
                            $competencies_questions_arr[$question->id] = $child->id;
                        }
                    }
                    */
                    $dictBankSetsItemDictBankComQuestion = DictBankSetsCompetenciesQuestion::where('dict_bank_sets_items_id',$col->id)->get();
                    foreach($dictBankSetsItemDictBankComQuestion as $question) {
                        $child = new DictBankSetsCompetenciesQuestion;
                        $child->dict_bank_sets_items_id = $id;
                        $child->title_eng = $question->title_eng;
                        $child->title_mal = $question->title_mal;
                        $child->flag = $question->flag;
                        $child->delete_id = $question->delete_id;

                        if($child->save()) {
                            $competencies_questions_arr[$question->id] = $child->id;
                        }
                    }
                    /*
                    if(empty($col->dictBankSetsItemsScoresSetsGrade)) {
                        $mdl->loadMissing('dictBankSetsItemsScoresSetsGrade');
                    }

                    foreach($col->dictBankSetsItemsScoresSetsGrade as $set_score) {
                        if(isset($grade_arr[$set_score->dict_bank_grades_id])) {
                            $n = new DictBankSetsItemsScoresSetsGrade;
                            $n->dict_bank_sets_items_id = $id;
                            $n->tech_discipline_flag = $set_score->tech_discipline_flag;
                            $n->dict_bank_grades_id = $grade_arr[$set_score->dict_bank_grades_id];
                            $n->score = $set_score->score;
                            $n->flag = $set_score->flag;
                            $n->delete_id = $set_score->delete_id;

                            $n->save();
                        }

                    }
                    */
                    $dictBankSetsItemsScoresSetsGrade = DictBankSetsItemsScoresSetsGrade::where('dict_bank_sets_items_id',$col->id)->get();
                    foreach($dictBankSetsItemsScoresSetsGrade as $set_score) {
                        if(isset($grade_arr[$set_score->dict_bank_grades_id])) {
                            $n = new DictBankSetsItemsScoresSetsGrade;
                            $n->dict_bank_sets_items_id = $id;
                            $n->tech_discipline_flag = $set_score->tech_discipline_flag;
                            $n->dict_bank_grades_id = $grade_arr[$set_score->dict_bank_grades_id];
                            $n->score = $set_score->score;
                            $n->flag = $set_score->flag;
                            $n->delete_id = $set_score->delete_id;

                            $n->save();
                        }

                    }
                }
            }

            $jobgroup_sets_cols = DictBankJobgroupSet::where('dict_bank_sets_id',$old_penilaian_id)->get();

            foreach($jobgroup_sets_cols as $col) {
                $mdl= new DictBankJobgroupSet;
                $mdl->dict_bank_sets_id = $penilaian_id;
                $mdl->jurusan_id = $col->jurusan_id;
                $mdl->dict_bank_grades_categories_id = $grade_categories_arr[$col->dict_bank_grades_categories_id];
                $mdl->title_mal = $col->title_mal;
                $mdl->desc_mal = $col->desc_mal;
                $mdl->title_eng = $col->title_eng;
                $mdl->desc_eng = $col->desc_eng;
                $mdl->flag = $col->flag;
                $mdl->delete_id = $col->delete_id;

                if($mdl->save()) {
                    $jobgroup_sets_id = $mdl->id;
                    /*
                    if(empty($col->dictBankJobgroupSetItems)) {
                        $mdl->loadMissing('dictBankJobgroupSetItems');
                    }
                    foreach($col->dictBankJobgroupSetItems as $item) {
                        $child = new DictBankJobgroupSetsItem;
                        $child->dict_bank_jobgroup_sets_id = $jobgroup_sets_id;
                        $child->flag = $item->flag;
                        $child->delete_id = $item->delete_id;
                        $child->dict_bank_sets_items_id = $sets_items_arr[$item->dict_bank_sets_items_id];

                        if($child->save()) {
                            if(empty($col->dictBankJobgroupSetsItemsScoresSetsGrade)) {
                                $mdl->loadMissing('dictBankJobgroupSetsItemsScoresSetsGrade');
                            }
                            foreach($col->dictBankJobgroupSetsItemsScoresSetsGrade as $item_scoreset) {
                                if(isset($grade_arr[$item_scoreset->dict_bank_grades_id])) {
                                    $anak = new DictBankJobgroupSetsItemsScoresSetsGrade;
                                    $anak->dict_bank_jobgroup_sets_items_id = $child->id;
                                    $anak->dict_bank_grades_id = $grade_arr[$item_scoreset->dict_bank_grades_id];
                                    $anak->dict_bank_jobgroup_sets_id = $jobgroup_sets_id;
                                    $anak->score = $item_scoreset->score;
                                    $anak->flag = $item_scoreset->flag;
                                    $anak->delete_id = $item_scoreset->delete_id;

                                    $anak->save();
                                }

                            }
                        }

                    }
                    */
                    $dictBankJobgroupSetItems = DictBankJobgroupSetsItem::where('dict_bank_jobgroup_sets_id',$col->id)->get();
                    foreach($dictBankJobgroupSetItems as $item) {
                        $child = new DictBankJobgroupSetsItem;
                        $child->dict_bank_jobgroup_sets_id = $jobgroup_sets_id;
                        $child->flag = $item->flag;
                        $child->delete_id = $item->delete_id;
                        $child->dict_bank_sets_items_id = $sets_items_arr[$item->dict_bank_sets_items_id];

                        if($child->save()) {
                            $dictBankJobgroupSetsItemsScoresSetsGrade = DictBankJobgroupSetsItemsScoresSetsGrade::where('dict_bank_jobgroup_sets_items_id',$item->id)->get();
                            foreach($dictBankJobgroupSetsItemsScoresSetsGrade as $item_scoreset) {
                                if(isset($grade_arr[$item_scoreset->dict_bank_grades_id])) {
                                    $anak = new DictBankJobgroupSetsItemsScoresSetsGrade;
                                    $anak->dict_bank_jobgroup_sets_items_id = $child->id;
                                    $anak->dict_bank_grades_id = $grade_arr[$item_scoreset->dict_bank_grades_id];
                                    $anak->dict_bank_jobgroup_sets_id = $jobgroup_sets_id;
                                    $anak->score = $item_scoreset->score;
                                    $anak->flag = $item_scoreset->flag;
                                    $anak->delete_id = $item_scoreset->delete_id;

                                    $anak->save();
                                }

                            }
                        }
                    }
                }
            }

            return [
                'success' => 1,
                'data' => [
                    'trigger' => $trigger
                ]
            ];
        }else{
            return [
                'success' => 0,
            ];
        }
    }
}
