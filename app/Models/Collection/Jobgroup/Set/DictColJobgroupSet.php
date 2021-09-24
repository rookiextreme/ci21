<?php
namespace App\Models\Collection\Jobgroup\Set;

use Illuminate\Database\Eloquent\Model;

class DictColJobgroupSet extends Model{
    public function dictColJobgroupSetProfile(){
        return $this->hasOne('App\Models\Profiles\Profile', 'id', 'profiles_id');
    }

    public function dictColJobgroupSetYear(){
        return $this->hasOne('App\Models\Regular\Year', 'id', 'years_id');
    }

    public function dictColJobgroupSetJurusan(){
        $this->hasOne('App\Models\Mykj\LJurusan', 'id', 'jurusan_id');
    }

    public function dictColJobgroupSetDictGradeCategory(){
        $this->hasOne('App\Models\Collection\Grade\DictColGradeCategory', 'id', 'dict_col_grades_categories_id');
    }
}
