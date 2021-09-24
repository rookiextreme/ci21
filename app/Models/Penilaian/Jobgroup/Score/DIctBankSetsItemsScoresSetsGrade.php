<?php
namespace App\Models\Penilaian\Jobgroup\Score;

use Illuminate\Database\Eloquent\Model;

class DIctBankSetsItemsScoresSetsGrade extends Model{
    public function dictBankJobgroupScoreGradeDictBankItem(){
        return $this->hasOne('App\Models\Penilaian\Jobgroup\Set\DictBankJobgroupSetsItem', 'id', 'dict_bank_jobgroup_sets_items_id');
    }

    public function dictBankJobgroupScoreGradeDictBankGrade(){
        return $this->hasOne('App\Models\Penilaian\Grade\DictBankGrade', 'id', 'dict_bank_grades_id');
    }
}
