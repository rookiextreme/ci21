<?php
namespace App\Models\Collection\Setting\MeasuringLvl;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class DictColMeasuringlvl extends Model{
    public $table = 'dict_col_measuring_lvls';

    public function createAndUpdate(Request $request) : array{
        $measuring_lvl_nama = $request->input('measuring_lvl_nama');
        $measuring_lvl_id = $request->input('measuring_lvl_id');
        $trigger = $request->input('trigger');

        if($trigger == 0){
            $checkDup = self::getDuplicate($measuring_lvl_nama);
            $model = self::getRecord();
            $model->flag = 1;
            $model->delete_id = 0;
        }else{
            $checkDup = self::getDuplicate($measuring_lvl_nama, $measuring_lvl_id);
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
