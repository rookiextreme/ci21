<?php
namespace App\Models\Penilaian\DictBank\Score;

use Illuminate\Database\Eloquent\Model;

class DictBankSetsItemsScoresSetsGrade extends Model{
    protected $table = 'dict_bank_sets_items_scores_sets_grades';

    public function dictBankScoreGradeDictBankItem(){
        return $this->hasOne('App\Models\Penilaian\DictBank\Set\DictBankSetsItem', 'id', 'dict_bank_sets_items_id');
    }

    public function dictBankScoreGradeDictBankGrade(){
        return $this->hasOne('App\Models\Penilaian\Grade\DictBankGrade', 'id', 'dict_bank_grades_id');
    }
}
