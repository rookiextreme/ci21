<?php

namespace App\Http\Controllers\Segment\Admin\Dictionary\Bank\items\Score;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penilaian\DictBank\Score\DictBankSetsItemsScoresSetsGrade;
use App\Models\Penilaian\Grade\DictBankGradeCategory;
use App\Models\Penilaian\DictBank\Set\DictBankSetsItem;

class BankItemsScoreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id) {
        $dict_bank_sets_id = $id;

        $dictBankSetsItemModel = DictBankSetsItem::find($id);

        $grade_cat_model = DictBankGradeCategory::where('dict_bank_sets_id',$dictBankSetsItemModel->dict_bank_sets_id)->get();

        return view('segment.admin.dictionarybank.penilainitem.score',[
            'grades' => $grade_cat_model->dictBankGradeCategoryGetGrade,
            ''
        ]);

        // $grade_col = array();
        // foreach($grade_cat_model as $cat) {
        //     foreach($cat->dictBankGradeCategoryGetGrade as $grade) {
        //         $grade_col[] = $grade; 
        //     }
        // }

        // $grade_col = my_array_unique($grade_col,true);
    }

    private function my_array_unique($array, $keep_key_assoc = false)
    {
        $duplicate_keys = array();
        $tmp         = array();       

        foreach ($array as $key=>$val)
        {
            // convert objects to arrays, in_array() does not support objects
            if (is_object($val))
                $val = (array)$val;

            if (!in_array($val, $tmp))
                $tmp[] = $val;
            else
                $duplicate_keys[] = $key;
        }

        foreach ($duplicate_keys as $key)
            unset($array[$key]);

        return $keep_key_assoc ? $array : array_values($array);
    }
}
