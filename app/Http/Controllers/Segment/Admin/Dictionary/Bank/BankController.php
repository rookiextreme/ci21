<?php

namespace App\Http\Controllers\Segment\Admin\Dictionary\Bank;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Penilaian\DictBank\Set\DictBankSet;
use App\Models\Penilaian\DictBank\Set\DictBankSetsItem;
use App\Models\Penilaian\Setting\Competency\DictBankCompentencyType;
use App\Models\Penilaian\Setting\Measuringlvl\DictBankMeasuringlvl;
use App\Models\Penilaian\Grade\DictBankGradeCategory;
use App\Models\Penilaian\Grade\DictBankGrade;
use App\Models\Collection\Setting\Competency\DictColCompetencyType;
use App\Models\Collection\Setting\Measuringlvl\DictColMeasuringlvl;
use App\Models\Collection\Grade\DictColGradeCategory;
use App\Models\Regular\Grade;
use App\Models\Regular\Year;
use App\Models\Profiles\Profile;
use DataTables;
use DateTime;

class BankController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request) {
        date_default_timezone_set('Asia/Kuala_Lumpur');

        $current_year = intval(date("Y"));

        $col_years = array();

        for ($i=0; $i < 11; $i++) { 
            $col_years[] = $current_year;
            $current_year += 1;
        }

        $competency_types = DictColCompetencyType::where('delete_id', 0)->where('flag',1)->get();
        $measuring_levels = DictColMeasuringlvl::where('delete_id', 0)->where('flag',1)->get();
        $grades = Grade::where('delete_id', 0)->where('flag', 1)->get();
        $grade_category = DictColGradeCategory::where('delete_id', 0)->where('flag', 1)->get();

        return view('segment.admin.dictionary.bank.index',[
            'years' => $col_years,
            'competency_types' => $competency_types,
            'measuring_levels' => $measuring_levels,
            'grades' => $grades,
            'grade_category' => $grade_category
        ]);
    }

    public function dict_bank_datalist(Request $request) {
        $model = DictBankSet::where('delete_id',0);

        return DataTables::of($model)
            ->setRowAttr([
                'data-dict-bank-id' => function($data) {
                    return $data->id;
                },
                'data-dict-bank-flag-id' => function($data) {
                    return $data->flag;
                },
            ])
            ->rawColumns(['action'])
            ->make(true);
    }

    public function load_grades_category(Request $request) {
        $input = $request->input('grade_category_id');

         $process = DictColGradeCategory::getRecord($input);

        $grade_listing = [];
        foreach($process->grades as $gL){
            $grade_listing[] = $gL->id;
        }

        $data = [];
        if($process){
            $data = [
                'success' => 1,
                'data' => [
                    'grade_list' => $grade_listing
                ]
            ];
        }
        return response()->json($data);
    }

    public function save_dict_bank(Request $request) {
        $year_id = Year::searchYear($request->input('year'));

        $title =  $request->input('title');
        $start_date = DateTime::createFromFormat('d-m-Y h:i A',$request->input('start_date'));
        $end_date = DateTime::createFromFormat('d-m-Y h:i A',$request->input('end_date'));
        $profile = Profile::where('users_id',Auth::user()->id)->first();
        $dt = new DateTime;

        $dict_bank_sets_data = [
            'profiles_id' => $profile->id,
            'years_id' => $year_id,
            'title' => $title,
            'tkh_mula' => $start_date->format('Y-m-d H:i:s.uT'),
            'tkh_tamat' => $end_date->format('Y-m-d H:i:s.uT'),
            'flag_publish' => 0,
            'flag' => 1,
            'delete_id' => 0,
            'ref_id' => 0,
            'created_at' => $dt->format('Y-m-d H:i:s.uT')
        ];
        
        $dict_bank_sets_id = DictBankSet::insertGetId($dict_bank_sets_data);

        if(isset($dict_bank_sets_id)) {
            $compentency_types = $request->input('compentency_type');

            if(isset($compentency_types)) {
                $ct = DictColCompetencyType::find($compentency_types);

                $dict_bank_competency_types_data = [
                    'name' => $ct->name,
                    'years_id' => $year_id,
                    'dict_col_competency_types_id' => $ct->id,
                    'dict_bank_sets_id' => $dict_bank_sets_id,
                    'flag' => 1,
                    'delete_id' => 0,
                    'created_at' => $dt->format('Y-m-d H:i:s.uT')
                ];

                $dict_bank_compentency_types_id = DictBankCompentencyType::insertGetId($dict_bank_competency_types_data);
            }

            $measuring_level = $request->input('measuring_level');

            if(isset($measuring_level)) {
                $ml = DictColMeasuringlvl::find($measuring_level);

                $dict_bank_measuring_lvls_data = [
                    'dict_col_measuring_lvls_id' => $ml->id,
                    'name' => $ml->name,
                    'flag' => 1,
                    'delete_id' => 0,
                    'created_at' => $dt->format('Y-m-d H:i:s.uT')
                ];

                $dict_bank_measuring_lvls_id = DictBankMeasuringlvl::insertGetId($dict_bank_measuring_lvls_data);
            }

            $grade_category = $request->input('grade_category');

            if(isset($grade_category)) {
                $gc = DictColGradeCategory::find($grade_category);

                $dict_bank_grades_categories_data = [
                    'dict_bank_sets_id' => $dict_bank_sets_id,
                    'dict_col_grades_categories_id' => $gc->id,
                    'name' => $gc->name,
                    'flag' => 1,
                    'delete_id' => 0,
                    'created_at' => $dt->format('Y-m-d H:i:s.uT')
                ];

                $dict_bank_grades_categories_id = DictBankGradeCategory::insertGetId($dict_bank_grades_categories_data);
            }

            $dict_bank_sets_items_data = [
                'dict_bank_sets_id' => $dict_bank_sets_id,
                'dict_bank_measuring_lvls_id' => $dict_bank_measuring_lvls_id,
                'dict_bank_grades_categories_id' => $dict_bank_grades_categories_id,
                'flag' => 1,
                'delete_id' => 0,
                'created_at' => $dt->format('Y-m-d H:i:s.uT')
            ];

            DictBankSetsItem::insert($dict_bank_sets_items_data);
       
            if(isset($dict_bank_grades_categories_id)) {
                $grades = json_decode($request->input('grades'),true);
                $gs = Grade::whereIn('id',$grades)->get();

                $dict_bank_grades_data = array();

                foreach($gs as $grade) {
                    $grade_data = [
                        'dict_bank_grades_categories_id' => $dict_bank_grades_categories_id,
                        'grades_id' => $grade->id,
                        'name' => $grade->name,
                        'flag' => 1,
                        'delete_id' => 0,
                        'created_at' => $dt->format('Y-m-d H:i:s.uT')
                    ];

                    $dict_bank_grades_data[] = $grade_data;
                }

                DictBankGrade::insert($dict_bank_grades_data);
            }

            $data = [
                'success' => 1,
                'data' => array()
            ];
        } else {
            $data = [
                'success' => 2,
                'data' => array()
            ];
        }

        return response()->json($data);
    }

    public function delete_dict_bank(Request $request) {
        $dict_bank_sets_id = $request->input('dict_bank_sets_id');

        DictBankSet::where('id',$dict_bank_sets_id)->update(['delete_id' => 1]);

        $data = [
            'success' => 1,
            'data' => array()
        ];

        return response()->json($data);
    }

    public function load_saved_dict_bank(Request $request) {
        $dict_bank_sets_id = $request->input('dict_bank_sets_id');

        $model = DictBankSetsItem::where('dict_bank_sets_id',$dict_bank_sets_id)->first();

        $grades = DictBankGrade::where('dict_bank_grades_categories_id')-get();

        $competency_type = DictBankCompentencyType::where('dict_bank_sets_id')->first();

        $grades_arr = array();

        for($grades as $grade){
            $grades_arr[] = $grade->grades_id; 
        }

        $data = [
            'success' => 1,
            'data' => [
                'dict_bank_id' => $dict_bank_sets_id,
                'measuring_level' => $model->dictBankSetsItemMeasuringLvl->dict_col_measuring_lvls_id,
                'competency_type' => $competency_type->dict_col_competency_types_id,
                'grade_category' => $model->dictBankSetsItemDictGradeCategory->dict_col_grades_categories_id,
                'grades' => $grades_arr
            ]
        ];

         $data = [
            'success' => 1,
            'data' => array()
        ];

        return response()->json($data);
    }
}
