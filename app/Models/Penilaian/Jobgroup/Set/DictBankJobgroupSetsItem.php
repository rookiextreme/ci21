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
}
