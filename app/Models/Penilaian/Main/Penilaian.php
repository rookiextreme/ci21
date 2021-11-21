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

class Penilaian extends Model{

    public function penilaianDictBankSet(){
        return $this->hasOne('App\Models\Penilaian\DictBank\Set\DictBankSet', 'id', 'dict_bank_sets_id');
    }

    public function penilaianPenyeliaProfiles(){
        return $this->hasOne('App\Models\Profiles\Profile', 'id', 'penyelia_profiles_id');
    }

    public function penilaianJobgroup(){
        return $this->hasOne('App\Models\Penilaian\Jobgroup\Set\DictBankJobgroupSet', 'id', 'dict_bank_jobgroup_sets_id');
    }

    public function penilaianPenilaianCom(){
        return $this->hasMany('App\Models\Penilaian\Main\PenilaiansCompetency', 'penilaians_id', 'id');
    }

    public static function checkPenilaian(){
        $dict_bank_set = DictBankSet::where('flag_publish', 1)->where('flag', 1)->where('delete_id', 0)->get();
        $getUserGrade = Auth::user()->user_profile->profile_Profile_cawangan_log_active->gred;
        $grade_id = Grade::where('name', $getUserGrade)->first()->id;
        $data['user'] = User::getPengguna(Auth::user()->user_profile->id);
        if(count($dict_bank_set) > 0){
            foreach($dict_bank_set as $dbs){
                $penilaian_percentage = 0;
                $penilaian_exist = $dbs->dictBankSetPenilaianUser;
                if(!$penilaian_exist){
                    $grade_cat = $dbs->dictBankSetGradeCategories;
                    if($grade_cat){
                        $grade_cat_id = $grade_cat->id;
                        $checkGradeAvailable = DictBankGrade::where('dict_bank_grades_categories_id', $grade_cat_id)->where('grades_id', $grade_id)->first();
                        if($checkGradeAvailable){
                            $createP = self::createNewPenilaian($dbs->id);
                            if($createP){
                                $data['penilaian_list'][$createP->id] = self::penilaianCollection($createP);
                            }
                        }
                    }
                }else{
                    $data['penilaian_list'][$penilaian_exist->id] = self::penilaianCollection($penilaian_exist);
                }
            }
            return $data;
        }else{
            return [];
        }
    }

    public static function createNewPenilaian($penilaian_id){
        $model = new Penilaian;
        $model->profiles_id = Auth::user()->user_profile->id;
        $model->dict_bank_sets_id = $penilaian_id;
        if($model->save()){
            self::scoreSetting($model);
            return $model;
        }else{
            return false;
        }
    }

    public static function scoreSetting($model){
        $dict_bank_set = $model->penilaianDictBankSet;
        if($dict_bank_set){
            $competencySet = $dict_bank_set->dictBankSetCompetencyScaleLvl;
            if($competencySet){
                foreach($competencySet as $cs){
                    $pcModel =  new PenilaiansCompetency;
                    $pcModel->penilaians_id = $model->id;
                    $pcModel->dict_bank_competency_types_scale_lvls_id = $cs->id;
                    if($pcModel->save()){
                        $items = DictBankSetsItem::where('dict_bank_sets_id', $dict_bank_set->id)->where('dict_bank_competency_types_scale_lvls_id', $pcModel->dict_bank_competency_types_scale_lvls_id)->get();
                        if(count($items) > 0){
                            foreach($items as $i){
                                $question = $i->dictBankSetsItemDictBankComQuestion;
                                if($question){
                                    foreach($question as $q){
                                        $scoreSetUser = new PenilaiansJawapan;
                                        $scoreSetUser->penilaians_competencies_id = $pcModel->id;
                                        $scoreSetUser->dict_bank_competencies_questions_id = $q->id;
                                        $scoreSetUser->dict_bank_sets_items_id = $i->id;
                                        $scoreSetUser->save();
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public static function penilaianCollection($penilaianModel){
        $data = [];

        $date1 = new DateTime($penilaianModel->penilaianDictBankSet->tkh_tamat);
        $date2 = $date1->diff(new DateTime('now'));

        $data['penilaian'] = [
            'name' => $penilaianModel->penilaianDictBankSet->title,
            'year' => $penilaianModel->penilaianDictBankSet->dictBankSetYear->year,
            'tkh_tutup' => $penilaianModel->penilaianDictBankSet->tkh_tamat,
            'tkh_remain' => $date2->days.' Hari '.$date2->h.' Jam '.$date2->i.' Minit ',
            'status' => $penilaianModel->status,
            'penyelia' => $penilaianModel->penilaianPenyeliaProfiles ? [
                'profile_id' => $penilaianModel->penilaianPenyeliaProfiles->profile_Users->id,
                'name' => $penilaianModel->penilaianPenyeliaProfiles->profile_Users->name,
            ] : null,
            'jobgroup' => $penilaianModel->penilaianJobgroup ? [
                'id' => $penilaianModel->penilaianJobgroup->id,
                'name' => $penilaianModel->penilaianJobgroup->title
            ] : null,
            'competencies' => self::penilaianCompetencyCollection($penilaianModel)
        ];

        return $data;
    }

    public static function penilaianCompetencyCollection($penilaianModel){
        $data = [];
        $competency = $penilaianModel->penilaianPenilaianCom;

        if($competency){
            foreach($competency as $c){
                $total = count($c->penilaianCompetencyJawapanTotal);
                $notAns = count($c->penilaianCompetencyJawapanNotAns);
                $ans = count($c->penilaianCompetencyJawapanAns);
                $percentageLengkap = number_format((float)($ans/$total) * 100, 2, '.', '');
                $data[] = [
                    'id' => $c->id,
                    'name' => $c->penilaianCompetencyActualCom->dictBankCompetencyTypeScaleBridgeCompetency->name,
                    'total' => $total,
                    'notAns' => $notAns,
                    'ans' => $ans,
                    'percentageLengkap' => $percentageLengkap,
                    'question' => self::penilanJawapanCollection($c)
                ];
            }
        }

        return $data;
    }

    public static function penilanJawapanCollection($items){
        $data = [];
        $questions = $items->penilaianCompetencyJawapan;

        if($questions){
            foreach($questions as $q){
                $data[] = [
                    'id' => $q->id,
                    'title' => $q->penilaianJawapanQuestion->title_eng
                ];
            }
        }

        return $data;
    }
}
