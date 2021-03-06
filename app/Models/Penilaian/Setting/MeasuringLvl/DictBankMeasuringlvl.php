<?php
namespace App\Models\Penilaian\Setting\Measuringlvl;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class DictBankMeasuringlvl extends Model{
	protected $table = 'dict_bank_measuring_lvls';

	public function dictColMeasuringLvls(){
        return $this->hasOne('App\Models\Collection\Setting\Measuringlvl\DictColMeasuringlvl', 'id', 'dict_col_measuring_lvls_id');
    }

    public function createAndUpdate(Request $request) : array{
        $measuring_lvl_nama = $request->input('measuring_lvl_nama');
        $measuring_lvl_id = $request->input('measuring_lvl_id');
        $penilaian_id = $request->input('penilaian_id');
        $trigger = $request->input('trigger');

        if($trigger == 0){
            $checkDup = self::getDuplicate($measuring_lvl_nama, $penilaian_id);
            $model = self::getRecord();
            $model->flag = 1;
            $model->delete_id = 0;
            $model->dict_bank_sets_id = $penilaian_id;
        }else{
            $checkDup = self::getDuplicate($measuring_lvl_nama, $penilaian_id, $measuring_lvl_id);
            $model = self::getRecord($measuring_lvl_id);
        }

        if($checkDup){
            return [
                'success' => 2
            ];
        }

        $model->name = $measuring_lvl_nama;

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

    public static function getDuplicate($nama, $bank_id, $id = false): bool{
        if(!$id){
            $model = self::where('name', 'ilike', '%'.$nama.'%')->where('dict_bank_sets_id',$bank_id)->where('delete_id', 0)->count();
        }else{
            $model = self::where('name', 'ilike', '%'.$nama.'%')->where('dict_bank_sets_id',$bank_id)->where('id', '!=', $id)->where('delete_id', 0)->count();
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
