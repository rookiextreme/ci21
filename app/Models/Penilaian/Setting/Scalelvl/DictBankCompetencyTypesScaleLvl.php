<?php
namespace App\Models\Penilaian\Setting\Scalelvl;

use Illuminate\Database\Eloquent\Model;

class DictBankCompetencyTypesScaleLvl extends Model{
    protected $table = "dict_bank_competency_types_scale_lvls";

    public function dictBankCompetencyTypeScaleBridgeCompetency(){
        return $this->hasOne('App\Models\Penilaian\Setting\Competency\DictBankCompetencyType', 'id', 'dict_bank_competency_types_id');
    }

    public function dictBankCompetencyTypeScaleBridgeScale(){
        return $this->hasOne('App\Models\Penilaian\Setting\Scalelvl\DictBankScaleLvl', 'id', 'dict_bank_scale_lvls_id');
    }
}
