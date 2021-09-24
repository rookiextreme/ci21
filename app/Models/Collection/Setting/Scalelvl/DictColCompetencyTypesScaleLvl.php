<?php
namespace App\Models\Collection\Setting\Scalelvl;

use Illuminate\Database\Eloquent\Model;

class DictColCompetencyTypesScaleLvl extends Model{
    public function dictColCompetencyTypeScaleBridgeCompetency(){
        return $this->hasOne('App\Models\Collection\Setting\Competency\DictColCompetencyType', 'id', 'dict_bank_competency_types_id');
    }

    public function dictColCompetencyTypeScaleBridgeScale(){
        return $this->hasOne('App\Models\Collection\Setting\Scalelvl\DictColScaleLvl', 'id', 'dict_bank_scale_lvls_id');
    }
}
