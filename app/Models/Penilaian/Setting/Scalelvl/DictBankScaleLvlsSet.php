<?php
namespace App\Models\Penilaian\Setting\Scalelvl;

use Illuminate\Database\Eloquent\Model;

class DictBankScaleLvlsSet extends Model{
    public function dictBankScaleLvlSetScaleParent(){
        return $this->hasOne('App\Models\Penilaian\Setting\Scalelvl\DictBankScaleLvl', 'id', 'dict_bank_scale_lvls_id');
    }

    public function dictBankScaleLvlSetSkill(){
        return $this->hasOne('App\Models\Penilaian\Setting\Scalelvl\DictBankScaleLvlsSkillset', 'id', 'dict_bank_scale_lvls_skillsets_id');
    }
}
