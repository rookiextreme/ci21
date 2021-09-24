<?php
namespace App\Models\Collection\Jobgroup\Set;

use Illuminate\Database\Eloquent\Model;

class DictColJobgroupSetsItem extends Model{
    public function dictColJobgroupSetsItemDictColJobgroupSet(){
        return $this->hasOne('App\Models\Collection\Jobgroup\Set\DictColJobgroupSet', 'id', 'dict_col_jobgroup_sets_id');
    }

    public function dictColJobgroupSetsItemDictColSetsItem(){
        return $this->hasOne('App\Models\Collection\DictCol\Set\DictColSetsItem', 'id', 'dict_col_sets_items_id');
    }
}
