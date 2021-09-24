<?php
namespace App\Models\Collection\DictCol\Set;

use Illuminate\Database\Eloquent\Model;

class DictColSetsItem extends Model{
    public function dictColSetsItemDictBankSet(){
        return $this->hasOne('App\Models\Collection\DictCol\Set\DictColSet', 'id', 'dict_col_sets_id');
    }

    public function dictColSetsItemMeasuringLvl(){
        return $this->hasOne('App\Models\Collection\Setting\MeasuringLvl\DictColMeasuringlvl', 'id', 'dict_col_measuring_lvls_id');
    }

    public function dictColSetsItemCompetencyTypeScaleLvl(){
        return $this->hasOne('App\Models\Collection\Setting\Scalelvl\DictColCompetencyTypesScaleLvl', 'id', 'dict_col_competency_types_scale_lvls_id');
    }

    public function dictColSetsItemJurusan(){
        $this->hasOne('App\Models\Mykj\LJurusan', 'id', 'jurusan_id');
    }

    public function dictColSetsItemDictGradeCategory(){
        $this->hasOne('App\Models\Collection\Grade\DictColGradeCategory', 'id', 'dict_col_grades_categories_id');
    }
}
