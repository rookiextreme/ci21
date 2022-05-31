<?php

namespace App\Models\Regular;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AgencyHierarchy extends Model
{
    use HasFactory;

    protected $table = 'agency_hierarchy';

    public static function getDuplicate($nama, $id = false): bool{
        if(!$id){
            $model = self::where('name', '=', $nama)->where('delete_id', 0)->count();
        }else{
            $model = self::where('name', '=', $nama)->where('id', '!=', $id)->where('delete_id', 0)->count();
        }


        return (bool)$model;
    }

    public static function getRecord($id = false) : self{
        if(!$id){
            $model = new self;
        }else{
            $model = self::find($id);
        }

        return $model;
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

    public function createAndUpdate(Request $request) : array{
        $agency_token = $request->input('agency');
        $parent_id = $request->input('parent');
        $agency_id = $request->input('agency_id');
        $trigger = $request->input('trigger');

        $agency_info = explode("-",$agency_token);

        if($trigger == 0){
            $checkDup = self::getDuplicate($agency_info[1]);
            $model = self::getRecord();
            $model->flag = 1;
            $model->delete_id = 0;
        }else{
            $model = self::getRecord($agency_id);
            if($model->name == $agency_info[1]) {
                $checkDup = false;
            } else {
                $checkDup = self::getDuplicate($agency_info[1], $agency_id);
            }

        }

        if($checkDup){
            return [
                'success' => 2
            ];
        }

        $model->name = $agency_info[1];
        $model->waran_code = $agency_info[0];

        if(!empty($parent_id)) {
           $model->parent_id =  $parent_id;
        }

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
}
