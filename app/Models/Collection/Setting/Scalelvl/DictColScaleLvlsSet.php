<?php
namespace App\Models\Collection\Setting\Scalelvl;

use Illuminate\Database\Eloquent\Model;

class DictColScaleLvlsSet extends Model{
    public function dictColScaleLvlSetScaleParent(){
        return $this->hasOne('App\Models\Collection\Setting\Scalelvl\DictColScaleLvl', 'id', 'dict_col_scale_lvls_id');
    }

    public function dictColScaleLvlSetSkill(){
        return $this->hasOne('App\Models\Collection\Setting\Scalelvl\DictColScaleLvlsSkillset', 'id', 'dict_col_scale_lvls_skillsets_id');
    }
}
