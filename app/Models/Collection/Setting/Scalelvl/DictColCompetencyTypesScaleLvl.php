<?php
namespace App\Models\Collection\Setting\Scalelvl;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class DictColCompetencyTypesScaleLvl extends Model{
    public function dictColCompetencyTypeScaleBridgeCompetency(){
        return $this->hasOne('App\Models\Collection\Setting\Competency\DictColCompetencyType', 'id', 'dict_col_competency_types_id');
    }

    public function dictColCompetencyTypeScaleBridgeScale(){
        return $this->hasOne('App\Models\Collection\Setting\Scalelvl\DictColScaleLvl', 'id', 'dict_col_scale_lvls_id');
    }

    public function createAndUpdate(Request $request) : array{
        $competency_type_set_com_type = $request->input('competency_type_set_com_type');
        $competency_type_set_scale_level = $request->input('competency_type_set_scale_level');
        $competency_type_set_id = $request->input('competency_type_set_id');

        $trigger = $request->input('trigger');

        if($trigger == 0){
            $checkDup = self::getDuplicate($competency_type_set_com_type, $competency_type_set_scale_level);
            $model = self::getRecord();
            $model->flag = 1;
            $model->delete_id = 0;
        }else{
            $checkDup = self::getDuplicate($competency_type_set_com_type, $competency_type_set_scale_level, $competency_type_set_id);
            $model = self::getRecord($competency_type_set_id);
        }

        if($checkDup){
            return [
                'success' => 2
            ];
        }

        $model->dict_col_competency_types_id = $competency_type_set_com_type;
        $model->dict_col_scale_lvls_id = $competency_type_set_scale_level;

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

    public static function getDuplicate($comtype, $scale_level, $id = false): bool{
        if(!$id){
            $model = self::where('dict_col_competency_types_id', $comtype)->where('dict_col_scale_lvls_id', $scale_level)->where('delete_id', 0)->count();
        }else{
            $model = self::where('dict_col_competency_types_id', $comtype)->where('dict_col_scale_lvls_id', $scale_level)->where('delete_id', 0)->where('id', '!=', $id)->where('delete_id', 0)->count();
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
