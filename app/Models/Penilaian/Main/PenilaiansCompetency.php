<?php
namespace App\Models\Penilaian\Main;

use App\Models\Mykj\Perkhidmatan;
use App\Models\Penilaian\DictBank\Score\DictBankSetsItemsScoresSetsGrade;
use App\Models\Penilaian\DictBank\Set\DictBankSetsItem;
use App\Models\Penilaian\Grade\DictBankGrade;
use App\Models\Penilaian\Grade\DictBankGradeCategory;
use App\Models\Penilaian\Jobgroup\Score\DictBankJobgroupSetsItemsScoresSetsGrade;
use App\Models\Penilaian\Jobgroup\Set\DictBankJobgroupSetsItem;
use App\Models\Regular\Grade;
use Illuminate\Database\Eloquent\Model;
use App\Models\Penilaian\Main\PenilaiansCompetenciesAvg;
use App\Models\Penilaian\Main\PenilaiansCompetenciesPenyeliaAvg;
use Auth;
use DB;

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

    public function penilaianCompetencyAvg(){
        return $this->hasMany('App\Models\Penilaian\Main\PenilaiansCompetenciesAvg', 'penilaians_competencies_id', 'id');
    }

    public function penilaianCompetencyPenyeliaAvg(){
        return $this->hasMany('App\Models\Penilaian\Main\PenilaiansCompetenciesPenyeliaAvg', 'penilaians_competencies_id', 'id');
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

    public static function comCalculate(PenilaiansCompetency $pc){

        $dict_bank_sets_id = $pc->penilaianCompetencyPenilaian->dict_bank_sets_id;
        $nokp = $pc->penilaianCompetencyPenilaian->profile_Users->profile_Users->nokp;
        $getStandardGred = $pc->penilaianCompetencyPenilaian->standard_gred;
        $getActualGred = $pc->penilaianCompetencyPenilaian->actual_gred;
        $getJobgroupId = $pc->penilaianCompetencyPenilaian->penilaianJobgroup->id;
        $getCompetency = $pc->penilaianCompetencyActualCom;
        $getCompetencyScale = $pc->penilaianCompetencyActualCom->dictBankCompetencyTypeScaleBridgeScale->name;
        $grade_id = Grade::where('name', 'like', '%'.$pc->penilaianCompetencyPenilaian->standard_gred.'%')->first()->id;
        $actualGrade_id = Grade::where('name', 'like', '%'.$getActualGred.'%')->first()->id;
        $ans = $pc->penilaianCompetencyJawapanAns;

        $data = [];

        $data[$getCompetency->id] = [
            'id' => $getCompetency->id,
            'name' => $getCompetency->dictBankCompetencyTypeScaleBridgeCompetency->name,
            'question' => []
        ];

        if($getCompetencyScale != 'Yes/No'){
            if($ans){
                foreach($ans as $mainA){
                    $score = $mainA->score;
                    $question = $mainA->penilaianJawapanQuestion;
                    $grade_category = $mainA->penilaianJawapanQuestion->dictBankQuestionItems->dict_bank_grades_categories_id;
                    $mainAItemId = $mainA->penilaianJawapanQuestion->dictBankQuestionItems->id;

                    //Standard Position
                    $dictBankGrade = DictBankGrade::where('dict_bank_grades_categories_id', $grade_category)->where('grades_id', $grade_id)->first();

                    if(!$dictBankGrade){
                        echo $grade_id;
                        echo '<br>';
                        echo $grade_category;
                        die();
                    }
                    $expectedScoreGet = DictBankSetsItemsScoresSetsGrade::where('dict_bank_grades_id', $dictBankGrade->id)->where('dict_bank_sets_items_id', $mainAItemId)->first();

                    if($expectedScoreGet){
                        $expectedScore = $expectedScoreGet->score;
                    }else{
                        $expectedScore = 0;
                    }

                    // echo '<pre>';
                    // print_r($mainAItemId);
                    // echo '</pre>';
                    // die();
                    $gap = $score - $expectedScore;
                    if($gap == 0){
                        $gapResult = 0;
                        $training = '--';
                    }elseif($gap > 0){
                        $gapResult = '+'.$gap;
                        $training = '--';
                    }elseif($gap < 0){
                        $gapResult = $gap;
                        $training = 'Required';
                    }

                    //Actual Position
                    $actualGrade_cat = DB::connection('pgsql')->select("Select * from dict_bank_grades_categories dbgc
                        join dict_bank_grades dbg on dbgc.id = dbg.dict_bank_grades_categories_id
                        join dict_bank_sets dbs on dbgc.dict_bank_sets_id = dbs.id
                    where dbs.id = '".$dict_bank_sets_id."'
                      and dbg.grades_id = '".$actualGrade_id."'
                    limit 1");

                    $actualDictBankGrade = DictBankGrade::where('dict_bank_grades_categories_id', $actualGrade_cat[0]->dict_bank_grades_categories_id)->where('grades_id', $actualGrade_id)->first();

                    if(stripos('Technical (Generic)', $getCompetency->dictBankCompetencyTypeScaleBridgeCompetency->name) != '' || stripos('Technical (Discipline)', $getCompetency->dictBankCompetencyTypeScaleBridgeCompetency->name) != ''){
                        $actualExpectedScoreGet = DictBankSetsItemsScoresSetsGrade::where('dict_bank_grades_id', $actualDictBankGrade->id)->where('dict_bank_sets_items_id', $mainAItemId)->first();

                        if($actualExpectedScoreGet){
                            $actualExpectedScore = $actualExpectedScoreGet->score;
                        }else{
                            $actualExpectedScore = 0;
                        }
                    }else{
                        $actual_item_id = $mainAItemId;
                        $getJgItemId = DictBankJobgroupSetsItem::where('dict_bank_jobgroup_sets_id', $getJobgroupId)->where('dict_bank_sets_items_id', $actual_item_id)->first();

                        if($getJgItemId){
                            $actualExpectedScoreGet = DictBankJobgroupSetsItemsScoresSetsGrade::where('dict_bank_grades_id', $actualDictBankGrade->id)->where('dict_bank_jobgroup_sets_items_id', $getJgItemId->id)->first();

                            if($actualExpectedScoreGet){
                                $actualExpectedScore = $actualExpectedScoreGet->score;
                            }else{
                                $actualExpectedScore = 0;
                            }
                        }else{
                            $actualExpectedScore = null;
                        }
                    }

                    $actualGap = $score - $actualExpectedScore;

                    if($actualExpectedScore != null){
                        if($actualGap == 0){
                            $actualGapResult = 0;
                            $actualTraining = '--';
                        }elseif($actualGap > 0){
                            $actualGapResult = '+'.$actualGap;
                            $actualTraining = '--';
                        }elseif($actualGap < 0){
                            $actualGapResult = $actualGap;
                            $actualTraining = 'Required';
                        }
                    }else{
                        $actualGapResult = null;
                        $actualTraining = null;
                    }


                    if($dictBankGrade){
                        $data[$getCompetency->id]['question'][$mainA->penilaianJawapanQuestion->dictBankQuestionItems->id][] = [
                            'id' => $question->id,
                            'item_name' => $mainA->penilaianJawapanQuestion->dictBankQuestionItems->title_eng,
                            'expected_score' => $expectedScore,
                            'self_score' => $score,
                            'gap' => $gapResult,
                            'training' => $training,
                            'actual_expected_score' => $actualExpectedScore,
                            'actual_self_score' => $score,
                            'actual_gap' => $actualGapResult,
                            'actual_training' => $actualTraining,
                        ];
                    }
                }
            }

            foreach($data[$getCompetency->id]['question'] as $item_id => $qList){
                if(count($qList) == 1){
                     $avg = new PenilaiansCompetenciesAvg;
                     $avg->dict_bank_sets_items_id = $item_id;
                     $avg->penilaians_competencies_id = $pc->id;
                     $avg->score = $qList[0]['self_score'];
                     $avg->expected = $qList[0]['expected_score'];
                     $avg->dev_gap = $qList[0]['gap'];
                     $avg->training = $qList[0]['training'];
                     $avg->actual_expected = $qList[0]['actual_expected_score'];
                     $avg->actual_dev_gap = $qList[0]['actual_gap'];
                     $avg->actual_training = $qList[0]['actual_training'];
                     $avg->save();

                     $penyeliaAvg = new PenilaiansCompetenciesPenyeliaAvg();
                     $penyeliaAvg->dict_bank_sets_items_id = $item_id;
                     $penyeliaAvg->penilaians_competencies_id = $pc->id;
                     $penyeliaAvg->score = $qList[0]['self_score'];
                     $penyeliaAvg->expected = $qList[0]['expected_score'];
                     $penyeliaAvg->dev_gap = $qList[0]['gap'];
                     $penyeliaAvg->training = $qList[0]['training'];
                     $penyeliaAvg->actual_expected = $qList[0]['actual_expected_score'];
                     $penyeliaAvg->actual_dev_gap = $qList[0]['actual_gap'];
                     $penyeliaAvg->actual_training = $qList[0]['actual_training'];
                     $penyeliaAvg->save();
                }else{
                    foreach($qList as $qPerItem){
                        $avg = new PenilaiansCompetenciesAvg;
                        $avg->dict_bank_sets_items_id = $item_id;
                        $avg->penilaians_competencies_id = $pc->id;
                        $avg->score = $qPerItem['self_score'];
                        $avg->expected = $qPerItem['expected_score'];
                        $avg->dev_gap = $qPerItem['gap'];
                        $avg->training = $qPerItem['training'];
                        $avg->actual_expected = $qPerItem['actual_expected_score'];
                        $avg->actual_dev_gap = $qPerItem['actual_gap'];
                        $avg->actual_training = $qPerItem['actual_training'];
                        $avg->save();

                        $penyeliaAvg = new PenilaiansCompetenciesPenyeliaAvg;
                        $penyeliaAvg->dict_bank_sets_items_id = $item_id;
                        $penyeliaAvg->penilaians_competencies_id = $pc->id;
                        $penyeliaAvg->score = $qPerItem['self_score'];
                        $penyeliaAvg->expected = $qPerItem['expected_score'];
                        $penyeliaAvg->dev_gap = $qPerItem['gap'];
                        $penyeliaAvg->training = $qPerItem['training'];
                        $penyeliaAvg->actual_expected = $qPerItem['actual_expected_score'];
                        $penyeliaAvg->actual_dev_gap = $qPerItem['actual_gap'];
                        $penyeliaAvg->actual_training = $qPerItem['actual_training'];
                        $penyeliaAvg->save();
                    }
                }
            }
            //end here
        }else{
            if($ans){
                foreach($ans as $mainA){
                    $score = $mainA->score;
                    if($score == 1){
                        $question = $mainA->penilaianJawapanQuestion;
                        $grade_category = $mainA->penilaianJawapanQuestion->dictBankQuestionItems->dict_bank_grades_categories_id;
                        $mainAItemId = $mainA->penilaianJawapanQuestion->dictBankQuestionItems->id;

                        //Standard Position
                        $dictBankGrade = DictBankGrade::where('dict_bank_grades_categories_id', $grade_category)->where('grades_id', $grade_id)->first();
                        $expectedScoreGet = DictBankSetsItemsScoresSetsGrade::where('dict_bank_grades_id', $dictBankGrade->id)->where('dict_bank_sets_items_id', $mainAItemId)->first();

                        if($expectedScoreGet){
                            $expectedScore = $expectedScoreGet->score;
                        }else{
                            $expectedScore = 0;
                        }

                        if(!array_key_exists($mainA->penilaianJawapanQuestion->dictBankQuestionItems->id, $data[$getCompetency->id]['question'])){
                            $data[$getCompetency->id]['question'][$mainA->penilaianJawapanQuestion->dictBankQuestionItems->id] = [
                                'id' => $question->id,
                                'item_name' => $mainA->penilaianJawapanQuestion->dictBankQuestionItems->title_eng,
                                'expected_score' => $expectedScore,
                                'self_score' => 0,
                                'gap' => 0,
                                'training' => 0,
                                'actual_expected_score' => 0,
                                'actual_self_score' => 0,
                                'actual_gap' => 0,
                                'actual_training' => 0,
                            ];
                        }

                        $data[$getCompetency->id]['question'][$mainA->penilaianJawapanQuestion->dictBankQuestionItems->id]['self_score'] += 1;
                    }
                }

                if(!empty($data)){
                    foreach($data[$getCompetency->id]['question'] as $item_id => $itemVal){
                        //Actual Position
                        $actualGrade_cat = DB::connection('pgsql')->select("Select * from dict_bank_grades_categories dbgc
                            join dict_bank_grades dbg on dbgc.id = dbg.dict_bank_grades_categories_id
                            join dict_bank_sets dbs on dbgc.dict_bank_sets_id = dbs.id
                        where dbs.id = '".$dict_bank_sets_id."'
                          and dbg.grades_id = '".$actualGrade_id."'
                        limit 1"
                        );

                        $actualDictBankGrade = DictBankGrade::where('dict_bank_grades_categories_id', $actualGrade_cat[0]->dict_bank_grades_categories_id)->where('grades_id', $actualGrade_id)->first();

                        if(stripos('Technical (Generic)', $getCompetency->dictBankCompetencyTypeScaleBridgeCompetency->name) != '' || stripos('Technical (Discipline)', $getCompetency->dictBankCompetencyTypeScaleBridgeCompetency->name) != ''){
                            $actualExpectedScoreGet = DictBankSetsItemsScoresSetsGrade::where('dict_bank_grades_id', $actualDictBankGrade->id)->where('dict_bank_sets_items_id', $mainAItemId)->first();

                            if($actualExpectedScoreGet){
                                $actualExpectedScore = $actualExpectedScoreGet->score;
                            }else{
                                $actualExpectedScore = 0;
                            }
                        }else{

                            $actual_item_id = $mainA->penilaianJawapanQuestion->dictBankQuestionItems->id;
                            $getJgItemId = DictBankJobgroupSetsItem::where('dict_bank_jobgroup_sets_id', $getJobgroupId)->where('dict_bank_sets_items_id', $actual_item_id)->first();

                            if($getJgItemId){
                                $actualExpectedScoreGet = DictBankJobgroupSetsItemsScoresSetsGrade::where('dict_bank_grades_id', $actualDictBankGrade->id)->where('dict_bank_jobgroup_sets_items_id', $getJgItemId->id)->first();

                                if($actualExpectedScoreGet){
                                    $actualExpectedScore = $actualExpectedScoreGet->score;
                                }else{
                                    $actualExpectedScore = 0;
                                }
                            }else{
                                $actualExpectedScore = null;
                            }
                        }

                        $gap = $itemVal['self_score'] - $itemVal['expected_score'];

                        if($gap == 0){
                            $gapResult = 0;
                            $training = '--';
                        }elseif($gap > 0){
                            $gapResult = '+'.$gap;
                            $training = '--';
                        }elseif($gap < 0){
                            $gapResult = $gap;
                            $training = 'Required';
                        }

                        $actualGap = $itemVal['self_score'] - $actualExpectedScore;

                        if($actualExpectedScore != null){
                            if($actualGap == 0){
                                $actualGapResult = 0;
                                $actualTraining = '--';
                            }elseif($actualGap > 0){
                                $actualGapResult = '+'.$actualGap;
                                $actualTraining = '--';
                            }elseif($actualGap < 0){
                                $actualGapResult = $actualGap;
                                $actualTraining = 'Required';
                            }
                        }else{
                            $actualGapResult = null;
                            $actualTraining = null;
                        }

                        $data[$getCompetency->id]['question'][$item_id]['gap'] = $gapResult;
                        $data[$getCompetency->id]['question'][$item_id]['training'] = $training;
                        $data[$getCompetency->id]['question'][$item_id]['actual_expected_score'] = $actualExpectedScore;
                        $data[$getCompetency->id]['question'][$item_id]['actual_self_score'] = $score;
                        $data[$getCompetency->id]['question'][$item_id]['actual_gap'] = $actualGapResult;
                        $data[$getCompetency->id]['question'][$item_id]['actual_training'] = $actualTraining;

                        $avg = new PenilaiansCompetenciesAvg;
                        $avg->dict_bank_sets_items_id = $item_id;
                        $avg->penilaians_competencies_id = $pc->id;
                        $avg->score = $data[$getCompetency->id]['question'][$item_id]['self_score'];
                        $avg->expected = $data[$getCompetency->id]['question'][$item_id]['expected_score'];
                        $avg->dev_gap = $data[$getCompetency->id]['question'][$item_id]['gap'];
                        $avg->training = $data[$getCompetency->id]['question'][$item_id]['training'];
                        $avg->actual_expected = $data[$getCompetency->id]['question'][$item_id]['actual_expected_score'];
                        $avg->actual_dev_gap = $data[$getCompetency->id]['question'][$item_id]['actual_gap'];
                        $avg->actual_training = $data[$getCompetency->id]['question'][$item_id]['actual_training'];
                        $avg->save();

                        $penyeliaAvg = new PenilaiansCompetenciesPenyeliaAvg;
                        $penyeliaAvg->dict_bank_sets_items_id = $item_id;
                        $penyeliaAvg->penilaians_competencies_id = $pc->id;
                        $penyeliaAvg->score = $data[$getCompetency->id]['question'][$item_id]['self_score'];
                        $penyeliaAvg->expected = $data[$getCompetency->id]['question'][$item_id]['expected_score'];
                        $penyeliaAvg->dev_gap = $data[$getCompetency->id]['question'][$item_id]['gap'];
                        $penyeliaAvg->training = $data[$getCompetency->id]['question'][$item_id]['training'];
                        $penyeliaAvg->actual_expected = $data[$getCompetency->id]['question'][$item_id]['actual_expected_score'];
                        $penyeliaAvg->actual_dev_gap = $data[$getCompetency->id]['question'][$item_id]['actual_gap'];
                        $penyeliaAvg->actual_training = $data[$getCompetency->id]['question'][$item_id]['actual_training'];
                        $penyeliaAvg->save();
                    }
                }
                // echo '<pre>';
                // // print_r($data);
                // echo '</pre>';
                // die();
            }
        }
    }
}
