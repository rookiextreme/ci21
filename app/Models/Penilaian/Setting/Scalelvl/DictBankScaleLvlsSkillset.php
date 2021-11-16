<?php
namespace App\Models\Penilaian\Setting\Scalelvl;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class DictBankScaleLvlsSkillset extends Model{
    public function dictBankSkillGetSets(){
        return $this->hasMany('App\Models\Penilaian\Setting\Scalelvl\DictBankScaleLvlsSet', 'dict_bank_scale_lvls_skillsets_id', 'id');
    }

    public function createAndUpdate(Request $request) : array{
        $scale_skill_set_nama = $request->input('scale_skill_set_nama');
        $scale_skill_set_id = $request->input('scale_skill_set_id');
        $penilaian_id = $request->input('penilaian_id');
        $trigger = $request->input('trigger');

        if($trigger == 0){
            $checkDup = self::getDuplicate($scale_skill_set_nama);
            $model = self::getRecord();
            $model->flag = 1;
            $model->delete_id = 0;
            $model->dict_bank_sets_id = $penilaian_id;
        }else{
            $checkDup = self::getDuplicate($scale_skill_set_nama, $scale_skill_set_id);
            $model = self::getRecord($scale_skill_set_id);
        }

        if($checkDup){
            return [
                'success' => 2
            ];
        }

        $model->name = $scale_skill_set_nama;

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
