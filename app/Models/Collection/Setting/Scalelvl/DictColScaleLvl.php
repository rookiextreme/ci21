<?php
namespace App\Models\Collection\Setting\Scalelvl;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class DictColScaleLvl extends Model{

    public function dictColScaleLvlYear(){
        return $this->hasOne('App\Models\Regular\Year', 'id', 'years_id');
    }

    public function dictColScaleLvlToComScaleBridge(){
        return $this->hasMany('App\Models\Collection\Setting\Scalelvl\DictColCompetencyTypesScaleLvl', 'dict_bank_scale_lvls_id', 'id');
    }

    public function dictColScaleLvlScaleType(){
        return $this->hasOne('App\Models\Collection\Setting\Scalelvl\DictColScaleLvlsType', 'id', 'dict_bank_scale_lvls_types_id');
    }

    public function dictColScaleLvlScaleSet(){
        return $this->hasMany('App\Models\Collection\Setting\Scalelvl\DictColScaleLvlsSet', 'dict_bank_scale_lvls_id', 'id');
    }

    public function dictBankScaleLvlsSkillSets(){
        return $this->belongsToMany('App\Models\Penilaian\Setting\Scalelvl\DictBankScaleLvlsSkillset','dict_col_scale_lvls_skillsets','dict_col_scale_lvls_id','dict_col_scale_lvls_skillsets_id');
    }

    public function createAndUpdate(Request $request) : array{
        $scale_level_nama = $request->input('scale_level_nama');
        $scale_level_id = $request->input('scale_level_id');
        $trigger = $request->input('trigger');

        if($trigger == 0){
            $checkDup = self::getDuplicate($scale_level_nama);
            $model = self::getRecord();
            $model->flag = 1;
            $model->delete_id = 0;
        }else{
            $checkDup = self::getDuplicate($scale_level_nama, $scale_level_id);
            $model = self::getRecord($scale_level_id);
        }

        if($checkDup){
            return [
                'success' => 2
            ];
        }

        $model->name = $scale_level_nama;

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
