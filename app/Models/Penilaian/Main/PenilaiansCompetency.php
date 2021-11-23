<?php
namespace App\Models\Penilaian\Main;

use Illuminate\Database\Eloquent\Model;
use Auth;

class PenilaiansCompetency extends Model{
    public function penilaianCompetencyActualCom(){
        return $this->hasOne('App\Models\Penilaian\Setting\Scalelvl\DictBankCompetencyTypesScaleLvl', 'id', 'dict_bank_competency_types_scale_lvls_id');
    }

    public function penilaianCompetencyPenilaian(){
        return $this->hasOne('App\Models\Penilaian\Main\Penilaian', 'id', 'penilaians_id');
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

    public static function getScoreCompetencyQuestion($penilaian_id){
        $data = [];
        $penilaian = Penilaian::where('dict_bank_sets_id', $penilaian_id)->where('profiles_id', Auth::user()->user_profile->id)->first();

        if($penilaian->status == 0) {
            $model = PenilaiansCompetency::where('penilaians_id', $penilaian->id)->where('status', 0)->first();

            $getQuestion = $model->penilaianCompetencyJawapanTotal;

            $data['penilaian_info'] = [
                'title' => $model->penilaianCompetencyPenilaian->penilaianDictBankSet->title
            ];

            $data['competencies']['info'] = [
                'id' => $model->id,
                'title' => $model->penilaianCompetencyActualCom->dictBankCompetencyTypeScaleBridgeCompetency->name,
                'type' => count($model->penilaianCompetencyActualCom->dictBankCompetencyTypeScaleBridgeScale->dictBankScaleLvlScaleSet) > 0 ? 'multiple' : 'yes/no',
                'scoreList' => self::scoreInput($model)
            ];

            if ($getQuestion) {
                foreach ($getQuestion as $gQ) {
                    $data['competencies']['question'][] = [
                        'id' => $gQ->id,
                        'name' => $gQ->penilaianJawapanQuestion->title_eng,
                        'scoreList' => self::scoreInput($model, $gQ->id, $gQ->score)
                    ];
                }
            }
            return [
                'penilaian_status' => 0,
                'data' => $data
            ];
        }else{
            return [
                'penilaian_status' => 1,
                'user_penilaian_id' => $penilaian->id
            ];
        }
    }

    public static function scoreInput($model, $q_id = false, $score = false){
        $data['score_header'] = 0;
        $data['score_html'] = '';

        $scaleLvlScoreList = $model->penilaianCompetencyActualCom->dictBankCompetencyTypeScaleBridgeScale;
        if($scaleLvlScoreList){
            $type = $scaleLvlScoreList->name;

            if($type == 'Yes/No'){
                $scoreYes = '';
                $scoreNo = '';

                if($score === 1){
                    $scoreYes = 'checked';
                }
                if($score === 0){
                    $scoreNo = 'checked';
                }
                $headerCount = 2;
                $data['score_header'] = $headerCount;
                $data['score_html'] .= '
                    <div class="demo-inline-spacing">
                    <div class="row question-ans" data-ques-id="'.$q_id.'">
                        <div class="col-md-6">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="q-list-'.$q_id.'" id="inlineRadio1" value="1" '.$scoreYes.'>
                                <label class="form-check-label" for="inlineRadio1" >Yes </label>
                            </div>
                        </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="q-list-'.$q_id.'" id="inlineRadio2" value="0" '.$scoreNo.'>
                                    <label class="form-check-label" for="inlineRadio2" >No</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    ';
                $data['scale_desc'][] = [];
            }else{
                $scaleLvlScoreListSet = $scaleLvlScoreList->dictBankScaleLvlScaleSet;
                $headerCount = 0;
                foreach($scaleLvlScoreListSet as $sSL){
                    $headerCount += 1;
                    $okCheck = '';
                    if($score == $headerCount){
                        $okCheck = 'checked';
                    }
                    $data['score_header'] = $headerCount;
                    $data['score_html'] .= '
                        <td>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" name="q-list-'.$q_id.'" type="radio" value="'.$headerCount.'" '.$okCheck.'>
                            </div>
                        </td>
                        ';
                    $data['scale_desc'][] = [
                        'skillset' => $sSL->dictBankScaleLvlSetSkill->name,
                        'description' => $sSL->name
                    ];
                }
            }
        }

        return $data;
    }
}
