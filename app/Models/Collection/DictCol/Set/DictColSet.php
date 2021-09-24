<?php
namespace App\Models\Collection\DictCol\Set;

use Illuminate\Database\Eloquent\Model;

class DictColSet extends Model{
    public function dictColSetProfile(){
        return $this->hasOne('App\Models\Profiles\Profile', 'id', 'profiles_id');
    }

    public function dictColSetYear(){
        return $this->hasOne('App\Models\Regular\Year', 'id', 'years_id');
    }
}
