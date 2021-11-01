<?php
namespace App\Models\Penilaian\DictBank\Set;

use Illuminate\Database\Eloquent\Model;

class DictBankSetsItem extends Model{
    protected $table = 'dict_bank_sets_items';

    public function dictBankSetsItemDictBankSet(){
        return $this->hasOne('App\Models\Penilaian\DictBank\Set\DictBankSet', 'id', 'dict_bank_sets_id');
    }

    public function dictBankSetsItemMeasuringLvl(){
        return $this->hasOne('App\Models\Penilaian\Setting\MeasuringLvl\DictBankMeasuringlvl', 'id', 'dict_bank_measuring_lvls_id');
    }

    public function dictBankSetsItemCompetencyTypeScaleLvl(){
        return $this->hasOne('App\Models\Penilaian\Setting\Scalelvl\DictBankCompetencyTypesScaleLvl', 'id', 'dict_bank_competency_typesScale_lvls_id');
    }

    public function dictBankSetsItemJurusan(){
        return $this->hasOne('App\Models\Mykj\LJurusan', 'id', 'jurusan_id');
    }

    public function dictBankSetsItemDictGradeCategory(){
        return $this->hasOne('App\Models\Penilaian\Grade\DictBankGradeCategory', 'id', 'dict_bank_grades_categories_id');
    }
}
