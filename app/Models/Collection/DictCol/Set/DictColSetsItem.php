<?php
namespace App\Models\Collection\DictCol\Set;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class DictColSetsItem extends Model{
    public function dictColSetsItemDictBankSet(){
        return $this->hasOne('App\Models\Collection\DictCol\Set\DictColSet', 'id', 'dict_col_sets_id');
    }

    public function dictColSetsItemMeasuringLvl(){
        return $this->hasOne('App\Models\Collection\Setting\MeasuringLvl\DictColMeasuringlvl', 'id', 'dict_col_measuring_lvls_id');
    }

    public function dictColSetsItemCompetencyTypeScaleLvl(){
        return $this->hasOne('App\Models\Collection\Setting\Scalelvl\DictColCompetencyTypesScaleLvl', 'id', 'dict_col_competency_types_scale_lvls_id');
    }

    public function dictColSetsItemJurusan(){
        return $this->hasOne('App\Models\Mykj\LJurusan', 'kod_jurusan', 'jurusan_id');
    }

    public function dictColSetsItemDictGradeCategory(){
        return $this->hasOne('App\Models\Collection\Grade\DictColGradeCategory', 'id', 'dict_col_grades_categories_id');
    }

    public function dictColSetsCompetenciesQuestions() {
        return $this->hasMany('App\Models\Collection\DictCol\Question\DictColSetsCompetenciesQuestion','id','dict_col_sets_items_id');
    }

    public function createAndUpdate(Request $request) : array{

        $dict_col_nama_eng = $request->input('dict_col_nama_eng');
        $dict_col_name_melayu = $request->input('dict_col_name_melayu');
        $dict_col_measuring_level = $request->input('dict_col_measuring_level');
        $dict_col_com_type = $request->input('dict_col_com_type');
        $dict_col_jurusan = $request->input('dict_col_jurusan');
        $dict_col_grade_category = $request->input('dict_col_grade_category');

        $dict_col_id = $request->input('dict_col_id');
        $trigger = $request->input('trigger');

        if($trigger == 0){
            $checkDup = self::getDuplicate($dict_col_nama_eng, $dict_col_measuring_level, $dict_col_com_type, $dict_col_jurusan, $dict_col_grade_category);
            $model = self::getRecord();
            $model->flag = 1;
            $model->delete_id = 0;
        }else{
            $checkDup = self::getDuplicate($dict_col_nama_eng, $dict_col_measuring_level, $dict_col_com_type, $dict_col_jurusan, $dict_col_grade_category, $dict_col_id);
            $model = self::getRecord($dict_col_id);
        }

        if($checkDup){
            return [
                'success' => 2
            ];
        }

        $model->title_eng = $dict_col_nama_eng;
        $model->title_mal = $dict_col_name_melayu;
        $model->dict_col_measuring_lvls_id = $dict_col_measuring_level;
        $model->dict_col_competency_types_scale_lvls_id = $dict_col_com_type;
        $model->jurusan_id = $dict_col_jurusan;
        $model->dict_col_grades_categories_id = $dict_col_grade_category;

        if($model->save()){
            return [
                'success' => 1,
                'data' => [
                    'id' => $model->id,
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

    public static function getDuplicate($nama_eng, $measuring_level, $competency_type, $jurusan, $grade_category, $id = false): bool{
        if(!$id){
            $model = self::where('title_eng', 'ilike', '%'.$nama_eng.'%')->where('dict_col_measuring_lvls_id', $measuring_level)->where('dict_col_competency_types_scale_lvls_id', $competency_type)->where('jurusan_id', $jurusan)->where('dict_col_grades_categories_id', $grade_category)->where('delete_id', 0)->count();
        }else{
            $model = self::where('title_eng', 'ilike', '%'.$nama_eng.'%')->where('dict_col_measuring_lvls_id', $measuring_level)->where('dict_col_competency_types_scale_lvls_id', $competency_type)->where('jurusan_id', $jurusan)->where('dict_col_grades_categories_id', $grade_category)->where('id', '!=', $id)->where('delete_id', 0)->count();
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
}
