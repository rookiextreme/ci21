<?php
namespace App\Models\Penilaian\Grade;

use Illuminate\Database\Eloquent\Model;

class DictBankGrade extends Model{
    public function dictBankGradeGetGradeCategory(){
        return $this->hasMany('App\Models\Penilaian\Grade\DictBankGrade', 'dict_bank_grades_categories_id', 'id');
    }
}
