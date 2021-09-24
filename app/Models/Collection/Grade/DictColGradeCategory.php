<?php
namespace App\Models\Collection\Grade;

use Illuminate\Database\Eloquent\Model;

class DictColGradeCategory extends Model{
    public function dictColGradeCategoryGetGrade(){
        $this->hasOne('App\Models\Collection\Grade\DictColGrade', 'id', 'dict_col_grades_categories');
    }
}
