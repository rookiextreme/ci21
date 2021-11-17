<?php
namespace App\Models\Penilaian\Jobgroup\Set;

use Illuminate\Database\Eloquent\Model;

class DictBankJobgroupSetsItem extends Model{
    public function dictBankJobgroupSetsItemDictBankJobgroupSet(){
        return $this->hasOne('App\Models\Penilaian\Jobgroup\Set\DictBankJobgroupSet', 'id', 'dict_bank_jobgroup_sets_id');
    }

    public function dictBankJobgroupSetsItemDictBankSetsItem(){
        return $this->hasOne('App\Models\Penilaian\DictBank\Set\DictBankSetsItem', 'id', 'dict_bank_sets_items_id');
    }

    public function dictBankJobgroupSetItems(){
        return $this->hasMany('App\Models\Penilaian\Jobgroup\Set\DictBankJobgroupSetsItem', 'dict_bank_jobgroup_sets_id', 'id')->where('delete_id', 0)->where('flag', 1);
    }

    public function dictBankJobgroupSetItemsScore(){
        return $this->hasMany('App\Models\Penilaian\Jobgroup\Score\DictBankSetsItemsScoresSetsGrade', 'dict_bank_jobgroup_sets_items_id', 'id')->where('delete_id', 0)->where('flag', 1);
    }
}
