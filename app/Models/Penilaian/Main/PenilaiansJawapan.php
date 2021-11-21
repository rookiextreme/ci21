<?php
namespace App\Models\Penilaian\Main;

use Illuminate\Database\Eloquent\Model;

class PenilaiansJawapan extends Model{
    public function penilaianJawapanQuestion(){
        return $this->hasOne('App\Models\Penilaian\DictBank\Question\DictBankSetsCompetenciesQuestion', 'id', 'dict_bank_competencies_questions_id');
    }
}
