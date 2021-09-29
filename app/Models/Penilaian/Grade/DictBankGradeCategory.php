<?php
namespace App\Models\Penilaian\Grade;

use Illuminate\Database\Eloquent\Model;

class DictBankGradeCategory extends Model{
    public function dictBankGradeCategoryGetGrade(){
        return $this->hasMany('App\Models\Penilaian\Grade\DictBankGrade', 'id', 'dict_banks_grades_categories');
    }
}
