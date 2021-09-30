<?php
namespace App\Models\Collection\Grade;

use App\Models\Regular\Grade;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class DictColGradeCategory extends Model{
    public $table = 'dict_col_grades_categories';

    public function dictColGradeCategoryGetGrade(){
        return $this->hasMany('App\Models\Collection\Grade\DictColGrade', 'dict_col_grades_categories_id', 'id')->where('delete_id', 0);
    }

    public function createAndUpdate(Request $request) : array{
        $grade_category_nama = $request->input('grade_category_nama');
        $grade_category_grade_listing = json_decode($request->input('grade_category_grade_listing'));
        $grade_category_id = $request->input('grade_category_id');
        $trigger = $request->input('trigger');

        if($trigger == 0){
            $checkDup = self::getDuplicate($grade_category_nama);
            $model = self::getRecord();
            $model->flag = 1;
            $model->delete_id = 0;
        }else{
            $checkDup = self::getDuplicate($grade_category_nama, $grade_category_id);
            $model = self::getRecord($grade_category_id);
        }

        if($checkDup){
            return [
                'success' => 2
            ];
        }

        $model->name = $grade_category_nama;

        if($model->save()){
            $gradeProcess = self::gradeProcessing($grade_category_grade_listing, $model->id);
            self::resetUnwantedGrade($grade_category_grade_listing, $model->id);

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

    public static function getRecord($id = false) : self{
        if(!$id){
            $model = new self;
        }else{
            $model = self::find($id);
        }

        return $model;
    }

    public static function getDuplicate($nama, $id = false): bool{
        if(!$id){
            $model = self::where('name', 'ilike', '%'.$nama.'%')->where('delete_id', 0)->count();
        }else{
            $model = self::where('name', 'ilike', '%'.$nama.'%')->where('id', '!=', $id)->where('delete_id', 0)->count();
        }


        return (bool)$model;
    }

    public function rekodActivate($id){
        $model = self::getRecord($id);
        $model->flag = $model->flag == 0 ? 1 : 0;

        if($model->save()){
            return [
                'success' => 1,
                'data' => [
                    'id' => $model->id,
                    'flag' => $model->flag
                ]
            ];
        }
    }

    public function gradeProcessing($listing, $grade_category_id) : bool{
        $pass = 0;

        foreach($listing as $gL){
            $model = DictColGrade::where('grades_id',  $gL)->where('dict_col_grades_categories_id', $grade_category_id)->first();
            if(!$model){
                $model = new DictColGrade;
                $model->dict_col_grades_categories_id = $grade_category_id;
                $model->grades_id = $gL;
                $model->flag = 1;
                $model->delete_id = 0;
            }else{
                $model->delete_id = 0;
            }
            if($model->save()){
                $pass += 0;
            }else{
                $pass += 1;
            }
        }
        return !($pass == 1);
    }

    public function resetUnwantedGrade($listing, $grade_category_id){
        $model = DictColGrade::whereNotIn('grades_id', $listing)->where('dict_col_grades_categories_id', $grade_category_id)->get();
        if(count($model) > 0){
            foreach($model as $gL){
                $gL->delete_id = 1;
                $gL->save();
            }
        }
    }
}
