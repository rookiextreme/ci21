<?php
namespace App\Models\Collection\Setting\Competency;

use Illuminate\Database\Eloquent\Model;

class DictColCompetencyType extends Model{
    public function dictColCompetencyTypeYear(){
        return $this->hasOne('App\Models\Regular\Year', 'id', 'years_id');
    }

    public function dictColCompetencyTypeScaleBridge(){
        return $this->hasMany('App\Models\Collection\Setting\Scalelvl\DictColCompetencyTypesScaleLvl', 'dict_col_competency_types_id', 'id');
    }
}
