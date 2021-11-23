<?php
namespace App\Models\Penilaian\DictBank\Set;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Auth;

class DictBankSet extends Model{

    public function dictBankSetProfile(){
        return $this->hasOne('App\Models\Profiles\Profile', 'id', 'profiles_id');
    }

    public function dictBankSetYear(){
        return $this->hasOne('App\Models\Regular\Year', 'id', 'years_id');
    }

    public function dictBankSetGradeCategories(){
        return $this->hasOne('App\Models\Penilaian\Grade\DictBankGradeCategory', 'dict_bank_sets_id', 'id');
    }

    public function dictBankSetGradeCategoriesAll(){
        return $this->hasMany('App\Models\Penilaian\Grade\DictBankGradeCategory', 'dict_bank_sets_id', 'id');
    }

    public function dictBankSetPenilaianUser(){
        return $this->hasOne('App\Models\Penilaian\Main\Penilaian', 'dict_bank_sets_id', 'id')->where('profiles_id', Auth::user()->user_profile->id);
    }

    public function dictBankSetDictBankSetsItem(){
        return $this->hasMany('App\Models\Penilaian\DictBank\Set\DictBankSetsItem', 'dict_bank_sets_id', 'id');
    }

    public function dictBankSetCompetencyScaleLvl(){
        return $this->hasMany('App\Models\Penilaian\Setting\Scalelvl\DictBankCompetencyTypesScaleLvl', 'dict_bank_sets_id', 'id');
    }

    public function createAndUpdate(Request $request) : array{
        $penilaian_nama = $request->input('penilaian_nama');
        $penilaian_tahun = $request->input('penilaian_tahun');
        $penilaian_tkh_mula = $request->input('penilaian_tkh_mula');
        $penilaian_tkh_tamat = $request->input('penilaian_tkh_tamat');
        $penilaian_id = $request->input('penilaian_id');
        $trigger = $request->input('trigger');

        if($trigger == 0){
            $checkDup = self::getDuplicate($penilaian_nama);
            $model = self::getRecord();
            $model->flag_publish = 0;
            $model->flag = 1;
            $model->delete_id = 0;
        }else{
            $checkDup = self::getDuplicate($penilaian_nama, $penilaian_id);
            $model = self::getRecord($penilaian_id);
        }

        if($checkDup){
            return [
                'success' => 2
            ];
        }

        $model->title = $penilaian_nama;
        $model->years_id = $penilaian_tahun;
        $model->tkh_mula = $penilaian_tkh_mula;
        $model->tkh_tamat = $penilaian_tkh_tamat;
        $model->ref_id = 0;

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
            $model = self::where('title', 'ilike', '%'.$nama.'%')->where('delete_id', 0)->count();
        }else{
            $model = self::where('title', 'ilike', '%'.$nama.'%')->where('id', '!=', $id)->where('delete_id', 0)->count();
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
