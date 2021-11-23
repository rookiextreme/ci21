<?php
namespace App\Models\Penilaian\Setting\Competency;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class DictBankCompetencyType extends Model{
    protected $table = 'dict_bank_competency_types';

    public function dictBankCompetencyTypeYear(){
        return $this->hasOne('App\Models\Regular\Year', 'id', 'years_id');
    }

    public function dictBankCompetencyTypeScaleBridge(){
        return $this->hasMany('App\Models\Penilaian\Setting\Scalelvl\DictBankCompetencyTypesScaleLvl', 'dict_bank_competency_types_id', 'id');
    }

    public function dictColCompetencyTypes(){
        return $this->hasOne('App\Models\Collection\Setting\Competency\DictColCompetencyType', 'id', 'dict_col_competency_types_id');
    }

    public function createAndUpdate(Request $request) : array{
        $competency_type_nama = $request->input('competency_type_nama');
        $competency_type_id = $request->input('competency_type_id');
        $penilaian_id = $request->input('penilaian_id');
        $tech_discipline_flag = $request->input('tech_discipline_flag');
        $trigger = $request->input('trigger');

        if($trigger == 0){
            $checkDup = self::getDuplicate($competency_type_nama);
            $model = self::getRecord();
            $model->flag = 1;
            $model->delete_id = 0;
            $model->dict_bank_sets_id = $penilaian_id;
        }else{
            $checkDup = self::getDuplicate($competency_type_nama, $competency_type_id);
            $model = self::getRecord($competency_type_id);
        }

        if($checkDup){
            return [
                'success' => 2
            ];
        }

        $model->name = $competency_type_nama;
        $model->tech_discipline_flag = $tech_discipline_flag;

        if($model->save()){
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
}
