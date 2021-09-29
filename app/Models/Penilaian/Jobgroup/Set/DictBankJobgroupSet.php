<?php
namespace App\Models\Penilaian\Jobgroup\Set;

use Illuminate\Database\Eloquent\Model;

class DictBankJobgroupSet extends Model{
    public function dictBankJobgroupSetProfile(){
        return $this->hasOne('App\Models\Profiles\Profile', 'id', 'profiles_id');
    }

    public function dictBankJobgroupSetYear(){
        return $this->hasOne('App\Models\Regular\Year', 'id', 'years_id');
    }

    public function dictBankJobgroupSetJurusan(){
        return $this->hasOne('App\Models\Mykj\LJurusan', 'id', 'jurusan_id');
    }

    public function dictBankJobgroupSetDictGradeCategory(){
        return $this->hasOne('App\Models\Penilaian\Grade\DictBankGradeCategory', 'id', 'dict_bank_grades_categories_id');
    }

    public function dictBankJobgroupSetDictBankSet(){
        return $this->hasOne('App\Models\Penilaian\DictBank\Set\DictBankSet', 'id', 'dict_bank_sets_id');
    }
}
