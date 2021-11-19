<?php
namespace App\Models\Penilaian\Main;

use Illuminate\Database\Eloquent\Model;

class PenilaiansCompetency extends Model{
    public function penilaianCompetencyActualCom(){
        return $this->hasOne('App\Models\Penilaian\Setting\Scalelvl\DictBankCompetencyTypesScaleLvl', 'id', 'dict_bank_competency_types_scale_lvls_id');
    }

    public function penilaianCompetencyJawapan(){
        return $this->hasMany('App\Models\Penilaian\Main\PenilaiansJawapan', 'penilaians_competencies_id', 'id');
    }

    public function penilaianCompetencyJawapanTotal(){
        return $this->hasMany('App\Models\Penilaian\Main\PenilaiansJawapan', 'penilaians_competencies_id', 'id');
    }

    public function penilaianCompetencyJawapanNotAns(){
        return $this->hasMany('App\Models\Penilaian\Main\PenilaiansJawapan', 'penilaians_competencies_id', 'id')->where('score', null);
    }

    public function penilaianCompetencyJawapanAns(){
        return $this->hasMany('App\Models\Penilaian\Main\PenilaiansJawapan', 'penilaians_competencies_id', 'id')->where('score', '!=' ,null);
    }
}
