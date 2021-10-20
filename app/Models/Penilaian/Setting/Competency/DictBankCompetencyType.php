<?php
namespace App\Models\Penilaian\Setting\Competency;

use Illuminate\Database\Eloquent\Model;

class DictBankCompetencyType extends Model{
    protected $table = 'dict_bank_competency_types';
    
    public function dictBankCompetencyTypeYear(){
        return $this->hasOne('App\Models\Regular\Year', 'id', 'years_id');
    }

    public function dictBankCompetencyTypeScaleBridge(){
        return $this->hasMany('App\Models\Penilaian\Setting\Scalelvl\DictBankCompetencyTypesScaleLvl', 'dict_bank_competency_types_id', 'id');
    }
}
