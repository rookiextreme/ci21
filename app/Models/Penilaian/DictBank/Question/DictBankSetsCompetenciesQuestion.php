<?php
namespace App\Models\Penilaian\DictBank\Question;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class DictBankSetsCompetenciesQuestion extends Model{

    public function dictBankQuestionItems(){
        return $this->hasOne('App\Models\Penilaian\DictBank\Set\DictBankSetsItem', 'id', 'dict_bank_sets_items_id');
    }

	protected $table = 'dict_bank_sets_competencies_questions';

    public function createAndUpdate(Request $request) : array{
        $bank_col_ques_nama_eng = $request->input('bank_col_ques_nama_eng');
        $bank_col_ques_nama_melayu = $request->input('bank_col_ques_nama_melayu');
        $bank_col_id = $request->input('bank_col_id');
        $bank_col_ques_id = $request->input('bank_col_ques_id');
        $trigger = $request->input('trigger');

        if($trigger == 0){
            $checkDup = self::getDuplicate($bank_col_ques_nama_eng, false, $bank_col_id);
            $model = self::getRecord();
            $model->flag = 1;
            $model->delete_id = 0;
            $model->dict_bank_sets_items_id = $bank_col_id;
        }else{
            $checkDup = self::getDuplicate($bank_col_ques_nama_eng, $bank_col_ques_id, $bank_col_id);
            $model = self::getRecord($bank_col_ques_id);
        }

        if($checkDup){
            return [
                'success' => 2
            ];
        }

        $model->title_eng = $bank_col_ques_nama_eng;
        $model->title_mal = $bank_col_ques_nama_melayu;

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

    public static function getDuplicate($nama, $id = false, $set_item_id): bool{
        if(!$id){
            $model = self::where('title_eng', 'ilike', '%'.$nama.'%')->where('delete_id', 0)->where('dict_bank_sets_items_id',$set_item_id)->count();
        }else{
            $model = self::where('title_eng', 'ilike', '%'.$nama.'%')->where('id', '!=', $id)->where('delete_id', 0)->where('dict_bank_sets_items_id',$set_item_id)->count();
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
