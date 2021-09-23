<?php
namespace App\Models\Regular;

use Illuminate\Database\Eloquent\Model;

class Year extends Model{
    public function yearsGradesCategories(){
        return $this->hasMany('App\Models\Penilaian\Catgrade\GradesCategory', 'id', 'years_id');
    }

    public static function findOne($year_id){
        return Year::find($year_id)->year;
    }
}
