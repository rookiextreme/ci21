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

    public static function searchYear($year) {
        $model = Year::where('year',$year)->first();

        if(isset($model)) {
            return $model->id;
        } else {
            return Year::insertGetId(['year' => $year]);
        }
    }
}
