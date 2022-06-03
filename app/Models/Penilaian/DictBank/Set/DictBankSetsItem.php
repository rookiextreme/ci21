<?php
namespace App\Models\Penilaian\DictBank\Set;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class DictBankSetsItem extends Model{
    protected $table = 'dict_bank_sets_items';

    public function dictBankSetsItemDictBankSet(){
        return $this->hasOne('App\Models\Penilaian\DictBank\Set\DictBankSet', 'id', 'dict_bank_sets_id')->where('flag', 1)->where('delete_id', 0);
    }

    public function dictBankSetsItemMeasuringLvl(){
        return $this->hasOne('App\Models\Penilaian\Setting\MeasuringLvl\DictBankMeasuringlvl', 'id', 'dict_bank_measuring_lvls_id')->where('flag', 1)->where('delete_id', 0);
    }

    public function dictBankSetsItemCompetencyTypeScaleLvl(){
        return $this->hasOne('App\Models\Penilaian\Setting\Scalelvl\DictBankCompetencyTypesScaleLvl', 'id', 'dict_bank_competency_types_scale_lvls_id')->where('flag', 1)->where('delete_id', 0);
    }

    public function dictBankSetsItemJurusan(){
        return $this->hasOne('App\Models\Mykj\LJurusan', 'kod_jurusan', 'jurusan_id');
    }

    public function dictBankSetsItemDictGradeCategory(){
        return $this->hasOne('App\Models\Penilaian\Grade\DictBankGradeCategory', 'id', 'dict_bank_grades_categories_id')->where('flag', 1)->where('delete_id', 0);
    }

    public function dictBankSetsItemDictBankComQuestion(){
        return $this->hasMany('App\Models\Penilaian\DictBank\Question\DictBankSetsCompetenciesQuestion', 'dict_bank_sets_items_id', 'id');
    }

    public function dictBankSetsItemsScoresSetsGrade(){
        return $this->hasMany('App\Models\Penilaian\DictBank\Score\DictBankSetsItemsScoresSetsGrade', 'DictBankSetsItemsScoresSetsGrade', 'id');
    }

    public function createAndUpdate(Request $request) : array{

        $bank_col_nama_eng = $request->input('bank_col_nama_eng');
        $bank_col_name_melayu = $request->input('bank_col_nama_melayu');
        $bank_col_measuring_level = $request->input('bank_col_measuring_level');
        $bank_col_com_type = $request->input('bank_col_com_type');
        $bank_col_jurusan = $request->input('bank_col_jurusan');
        $bank_col_grade_category = $request->input('bank_col_grade_category');

        $bank_col_id = $request->input('bank_col_id');
        $bank_set_id = $request->input('bank_set_id');
        $trigger = $request->input('trigger');

        if($trigger == 0){
            $checkDup = self::getDuplicate($bank_col_nama_eng, $bank_col_measuring_level, $bank_col_com_type, $bank_col_jurusan, $bank_col_grade_category, $bank_set_id);
            $model = self::getRecord();
            $model->flag = 1;
            $model->delete_id = 0;
        }else{
            $checkDup = self::getDuplicate($bank_col_nama_eng, $bank_col_measuring_level, $bank_col_com_type, $bank_col_jurusan, $bank_col_grade_category, $bank_set_id, $bank_col_id);
            $model = self::getRecord($bank_col_id);
        }

        if($checkDup){
            return [
                'success' => 2
            ];
        }

        $model->title_eng = $bank_col_nama_eng;
        $model->title_mal = $bank_col_name_melayu;
        $model->dict_bank_measuring_lvls_id = $bank_col_measuring_level;
        $model->dict_bank_competency_types_scale_lvls_id = $bank_col_com_type;
        $model->jurusan_id = $bank_col_jurusan;
        $model->dict_bank_grades_categories_id = $bank_col_grade_category;
        $model->dict_bank_sets_id = $bank_set_id;
        $model->flag = 1;
        $model->delete_id = 0;

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

    public static function getDuplicate($nama_eng, $measuring_level, $competency_type, $jurusan, $grade_category, $parent_id, $id = false): bool{
        if(!$id){
            $model = self::where('title_eng', 'ilike', '%'.$nama_eng.'%')->where('dict_bank_measuring_lvls_id', $measuring_level)->where('dict_bank_competency_types_scale_lvls_id', $competency_type)->where('jurusan_id', $jurusan)->where('dict_bank_grades_categories_id', $grade_category)->where('delete_id', 0)->count();
        }else{
            $model = self::where('title_eng', 'ilike', '%'.$nama_eng.'%')->where('dict_bank_measuring_lvls_id', $measuring_level)->where('dict_bank_competency_types_scale_lvls_id', $competency_type)->where('jurusan_id', $jurusan)->where('dict_bank_grades_categories_id', $grade_category)->where('id', '!=', $id)->where('delete_id', 0)->count();
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
