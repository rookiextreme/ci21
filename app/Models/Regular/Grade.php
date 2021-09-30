<?php
namespace App\Models\Regular;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Grade extends Model{
    public function createAndUpdate(Request $request) : array{
        $grade_nama = $request->input('grade_nama');
        $grade_id = $request->input('grade_id');
        $trigger = $request->input('trigger');

        if($trigger == 0){
            $checkDup = self::getDuplicate($grade_nama);
            $model = self::getRecord();
            $model->flag = 1;
            $model->delete_id = 0;
        }else{
            $checkDup = self::getDuplicate($grade_nama, $grade_id);
            $model = self::getRecord($grade_id);
        }

        if($checkDup){
            return [
                'success' => 2
            ];
        }

        $model->name = $grade_nama;

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
