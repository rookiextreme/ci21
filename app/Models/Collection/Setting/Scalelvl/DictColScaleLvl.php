<?php
namespace App\Models\Collection\Setting\Scalelvl;

use Illuminate\Database\Eloquent\Model;

class DictColScaleLvl extends Model{
    public function dictColScaleLvlYear(){
        return $this->hasOne('App\Models\Regular\Year', 'id', 'years_id');
    }

    public function dictColScaleLvlToComScaleBridge(){
        return $this->hasMany('App\Models\Collection\Setting\Scalelvl\DictColCompetencyTypesScaleLvl', 'dict_bank_scale_lvls_id', 'id');
    }

    public function dictColScaleLvlScaleType(){
        return $this->hasOne('App\Models\Collection\Setting\Scalelvl\DictColScaleLvlsType', 'id', 'dict_bank_scale_lvls_types_id');
    }

    public function dictColScaleLvlScaleSet(){
        return $this->hasMany('App\Models\Collection\Setting\Scalelvl\DictColScaleLvlsSet', 'dict_bank_scale_lvls_id', 'id');
    }
}
