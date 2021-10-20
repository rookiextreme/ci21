<?php
namespace App\Models\Penilaian\Grade;

use Illuminate\Database\Eloquent\Model;

class DictBankGrade extends Model{
    protected $table = 'dict_bank_grades';

    public function dictBankGradeGetGradeCategory(){
        return $this->hasMany('App\Models\Penilaian\Grade\DictBankGrade', 'dict_bank_grades_categories_id', 'id');
    }
}
