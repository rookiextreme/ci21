<?php
namespace App\Models\Penilaian\DictBank\Set;

use Illuminate\Database\Eloquent\Model;

class DictBankSet extends Model{
    
    public function dictBankSetProfile(){
        return $this->hasOne('App\Models\Profiles\Profile', 'id', 'profiles_id');
    }

    public function dictBankSetYear(){
        return $this->hasOne('App\Models\Regular\Year', 'id', 'years_id');
    }
}
