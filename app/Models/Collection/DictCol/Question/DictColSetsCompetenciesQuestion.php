<?php
namespace App\Models\Collection\DictCol\Question;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class DictColSetsCompetenciesQuestion extends Model{
    public function createAndUpdate(Request $request) : array{
        $dict_col_ques_nama_eng = $request->input('dict_col_ques_nama_eng');
        $dict_col_ques_nama_melayu = $request->input('dict_col_ques_nama_melayu');

        $dict_col_id = $request->input('dict_col_id');
        $dict_col_ques_id = $request->input('dict_col_ques_id');
        $trigger = $request->input('trigger');

        if($trigger == 0){
            $checkDup = self::getDuplicate($dict_col_ques_nama_eng, $dict_col_id);
            $model = self::getRecord();
            $model->flag = 1;
            $model->delete_id = 0;
            $model->dict_col_sets_items_id = $dict_col_id;
        }else{
            $checkDup = self::getDuplicate($dict_col_ques_nama_eng, $dict_col_id, $dict_col_ques_id);
            $model = self::getRecord($dict_col_ques_id);
        }

        if($checkDup){
            return [
                'success' => 2
            ];
        }

        $model->title_eng = $dict_col_ques_nama_eng;
        $model->title_mal = $dict_col_ques_nama_melayu;

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

    public static function getRecord($id = false) : self{
        if(!$id){
            $model = new self;
        }else{
            $model = self::find($id);
        }

        return $model;
    }

    public static function getDuplicate($nama_eng, $dict_item_id, $id = false): bool{
        if(!$id){
            $model = self::where('title_eng', 'ilike', '%'.$nama_eng.'%')->where('dict_col_sets_items_id', $dict_item_id)->where('delete_id', 0)->count();
        }else{
            $model = self::where('title_eng', 'ilike', '%'.$nama_eng.'%')->where('dict_col_sets_items_id', $dict_item_id)->where('id', '!=', $id)->where('delete_id', 0)->count();
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
