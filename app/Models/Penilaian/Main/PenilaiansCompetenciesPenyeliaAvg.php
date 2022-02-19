<?php
namespace App\Models\Penilaian\Main;

use App\Models\Penilaian\DictBank\Set\DictBankSet;
use App\Models\Penilaian\DictBank\Set\DictBankSetsItem;
use App\Models\Penilaian\Grade\DictBankGrade;
use App\Models\Regular\Grade;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Auth;
use DateTime;
use App\Models\Penilaian\Main\PenilaiansCompetency;

class PenilaiansCompetenciesPenyeliaAvg extends Model{
    public function penilaianAvgItem(){
        return $this->hasOne('App\Models\Penilaian\DictBank\Set\DictBankSetsItem', 'id', 'dict_bank_sets_items_id');
    }
}
