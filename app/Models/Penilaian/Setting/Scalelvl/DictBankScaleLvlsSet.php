<?php
namespace App\Models\Penilaian\Setting\Scalelvl;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class DictBankScaleLvlsSet extends Model{
    protected $table = 'dict_bank_scale_lvls_sets';

    public function dictBankScaleLvlSetScaleParent(){
        return $this->hasOne('App\Models\Penilaian\Setting\Scalelvl\DictBankScaleLvl', 'id', 'dict_bank_scale_lvls_id');
    }

    public function dictBankScaleLvlSetSkill(){
        return $this->hasOne('App\Models\Penilaian\Setting\Scalelvl\DictBankScaleLvlsSkillset', 'id', 'dict_bank_scale_lvls_skillsets_id');
    }

    public function createAndUpdate(Request $request) : array{
        $scale_level_set_nama = $request->input('scale_level_set_nama');
        $scale_level_set_skill_set = $request->input('scale_level_set_skill_set');
        $scale_level_id = $request->input('scale_level_id');
        $scale_level_set_id = $request->input('scale_level_set_id');
        $trigger = $request->input('trigger');

        if($trigger == 0){
            $checkDup = self::getDuplicate($scale_level_set_nama, $scale_level_id, $scale_level_set_skill_set);
            $model = self::getRecord();
            $model->flag = 1;
            $model->delete_id = 0;
            $model->dict_bank_scale_lvls_id = $scale_level_id;
        }else{
            $checkDup = self::getDuplicate($scale_level_set_nama, $scale_level_id, $scale_level_set_skill_set, $scale_level_set_id);
            $model = self::getRecord($scale_level_set_id);
        }

        if($checkDup){
            return [
                'success' => 2
            ];
        }

        $model->name = $scale_level_set_nama;
        $model->dict_bank_scale_lvls_skillsets_id = $scale_level_set_skill_set;
        $model->score = 0;

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

    public static function getDuplicate($nama, $scale_lvl_id, $scale_level_set_skill_set, $id = false): bool{
        if(!$id){
            $model = self::where('name', 'ilike', '%'.$nama.'%')->where('dict_bank_scale_lvls_id', $scale_lvl_id)->where('dict_bank_scale_lvls_skillsets_id' , $scale_level_set_skill_set)->where('delete_id', 0)->count();
        }else{
            $model = self::where('name', 'ilike', '%'.$nama.'%')->where('dict_bank_scale_lvls_id', $scale_lvl_id)->where('dict_bank_scale_lvls_skillsets_id' , $scale_level_set_skill_set)->where('id', '!=', $id)->where('delete_id', 0)->count();
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
