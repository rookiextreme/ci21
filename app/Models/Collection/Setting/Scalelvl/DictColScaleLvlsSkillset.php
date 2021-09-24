<?php
namespace App\Models\Collection\Setting\Scalelvl;

use Illuminate\Database\Eloquent\Model;

class DictColScaleLvlsSkillset extends Model{
    public function dictColSkillGetSets(){
        return $this->hasMany('App\Models\Collection\Setting\Scalelvl\DictColScaleLvlsSet', 'dict_col_scale_lvls_skillsets_id', 'id');
    }
}
