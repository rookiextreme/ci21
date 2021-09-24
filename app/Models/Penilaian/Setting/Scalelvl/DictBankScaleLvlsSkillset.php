<?php
namespace App\Models\Penilaian\Setting\Scalelvl;

use Illuminate\Database\Eloquent\Model;

class DictBankScaleLvlsSkillset extends Model{
    public function dictBankSkillGetSets(){
        return $this->hasMany('App\Models\Penilaian\Setting\Scalelvl\DictBankScaleLvlsSet', 'dict_bank_scale_lvls_skillsets_id', 'id');
    }
}
