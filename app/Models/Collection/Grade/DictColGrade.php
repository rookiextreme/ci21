<?php
namespace App\Models\Collection\Grade;

use Illuminate\Database\Eloquent\Model;

class DictColGrade extends Model{
    public function dictColGradeGetGradeCategory(){
        return $this->hasMany('App\Models\Collection\Grade\DictColGrade', 'dict_col_grades_categories_id', 'id');
    }
}
