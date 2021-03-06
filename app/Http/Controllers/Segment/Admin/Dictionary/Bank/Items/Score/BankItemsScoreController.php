<?php

namespace App\Http\Controllers\Segment\Admin\Dictionary\Bank\items\Score;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penilaian\DictBank\Score\DictBankSetsItemsScoresSetsGrade;
use App\Models\Penilaian\Grade\DictBankGradeCategory;
use App\Models\Penilaian\DictBank\Set\DictBankSetsItem;
use App\Models\Penilaian\Setting\Scalelvl\DictBankCompetencyTypesScaleLvl;
use stdClass;

class BankItemsScoreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id) {
        $dict_bank_sets_id = $id;

        $dictBankSetsItemModel = DictBankSetsItem::find($id);
        $compTypeScaleLvlModel = DictBankCompetencyTypesScaleLvl::find($dictBankSetsItemModel->dict_bank_competency_types_scale_lvls_id);
        $compTypeModel = $compTypeScaleLvlModel->dictBankCompetencyTypeScaleBridgeCompetency;

        $grade_cat_model = DictBankGradeCategory::find($dictBankSetsItemModel->dict_bank_grades_categories_id);

        $grades_col = $grade_cat_model->dictBankGradeCategoryGetGrade;
        $array_gradeScores = array();

        if($grades_col) {
            foreach($grades_col as $grade) {
                $gradeScore = new stdClass;
                $gradeScore->id = $grade->id;
                $gradeScore->name = $grade->dictBankGradeGrade->name;
                $gradeScore->score = 0;

                $array_gradeScores[] = $gradeScore;
            }


        }

        // print_r($array_gradeScores);

        // die();

        $itemsScoreSets = DictBankSetsItemsScoresSetsGrade::where('dict_bank_sets_items_id',$dictBankSetsItemModel->id)->get();

        foreach($itemsScoreSets as $scoreSet) {
            foreach($array_gradeScores as $gradeScore) {
                if($gradeScore->id == $scoreSet->dict_bank_grades_id) {
                    $gradeScore->score = $scoreSet->score;
                }
            }
        }

        return view('segment.admin.dictionarybank.penilainitem.score',[
            'gradeScores' => $array_gradeScores,
            'item_name' => $dictBankSetsItemModel->title_eng,
            'item_id' => $dictBankSetsItemModel->id,
            'penilaian_id' => $dictBankSetsItemModel->dict_bank_sets_id,
            'tech_discipline_flag' => $compTypeModel->tech_discipline_flag
        ]);
    }

    public function save_scores(Request $request){
        $scoreArr = json_decode($request->input('scoreArr'));


        foreach($scoreArr as $sa){
            $set_item_id = $sa[0];
            $score_id = $sa[1];
            $score = $sa[2];
            $tech_flag = $sa[3];

            $model = DictBankSetsItemsScoresSetsGrade::where('dict_bank_sets_items_id', $set_item_id)->where('dict_bank_grades_id', $score_id)->first();

            if($model){
                $model->score = $score;
                $model->save();
            }else{
                $model = new DictBankSetsItemsScoresSetsGrade;
                $model->score = $score;
                $model->flag = 1;
                $model->delete_id = 0;
                $model->dict_bank_sets_items_id = $set_item_id;
                $model->dict_bank_grades_id = $score_id;
                $model->tech_discipline_flag = $tech_flag;
                $model->save();
            }
        }

        return response()->json([
            'success' => 1
        ]);
    }

    // private function my_array_unique($array, $keep_key_assoc = false)
    // {
    //     $duplicate_keys = array();
    //     $tmp         = array();

    //     foreach ($array as $key=>$val)
    //     {
    //         // convert objects to arrays, in_array() does not support objects
    //         if (is_object($val))
    //             $val = (array)$val;

    //         if (!in_array($val, $tmp))
    //             $tmp[] = $val;
    //         else
    //             $duplicate_keys[] = $key;
    //     }

    //     foreach ($duplicate_keys as $key)
    //         unset($array[$key]);

    //     return $keep_key_assoc ? $array : array_values($array);
    // }
}
