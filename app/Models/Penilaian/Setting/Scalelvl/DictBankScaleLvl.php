<?php
namespace App\Models\Penilaian\Setting\Scalelvl;

use Illuminate\Database\Eloquent\Model;

class DictBankScaleLvl extends Model{
    protected $table = 'dict_bank_scale_lvls';
    
    public function dictBankScaleLvlYear(){
        return $this->hasOne('App\Models\Regular\Year', 'id', 'years_id');
    }

    public function dictBankScaleLvlToComScaleBridge(){
        return $this->hasMany('App\Models\Penilaian\Setting\Scalelvl\DictBankCompetencyTypesScaleLvl', 'dict_bank_scale_lvls_id', 'id');
    }

    public function dictBankScaleLvlScaleType(){
        return $this->hasOne('App\Models\Penilaian\Setting\Scalelvl\DictBankScaleLvlsType', 'id', 'dict_bank_scale_lvls_types_id');
    }

    public function dictBankScaleLvlScaleSet(){
        return $this->hasMany('App\Models\Penilaian\Setting\Scalelvl\DictBankScaleLvlsSet', 'dict_bank_scale_lvls_id', 'id');
    }
}
