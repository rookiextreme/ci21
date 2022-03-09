<?php
namespace App\Models\Penilaian\Main;

use App\Models\Mykj\Perkhidmatan;
use App\Models\Penilaian\DictBank\Set\DictBankSet;
use App\Models\Penilaian\DictBank\Set\DictBankSetsItem;
use App\Models\Penilaian\Grade\DictBankGrade;
use App\Models\Penilaian\Grade\DictBankGradeCategory;
use App\Models\Regular\Grade;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Auth;
use DateTime;
use App\Models\Penilaian\Main\PenilaiansCompetency;
use DB;

class Penilaian extends Model{

    public function penilaianDictBankSet(){
        return $this->hasOne('App\Models\Penilaian\DictBank\Set\DictBankSet', 'id', 'dict_bank_sets_id');
    }

    public function profile_Users(){
        return $this->hasOne('App\Models\Profiles\Profile', 'id', 'profiles_id');
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

    public function penilaianPenilaianComWithAnswers(){
        return $this->hasMany('App\Models\Penilaian\Main\PenilaiansCompetency', 'penilaians_id', 'id')->with(['penilaianCompetencyAvg', 'penilaianCompetencyPenyeliaAvg']);
    }

    public function penilaianPenilaianComCheckIfDone(){
        return $this->hasMany('App\Models\Penilaian\Main\PenilaiansCompetency', 'penilaians_id', 'id')->where('status', '0');
    }

    public static function checkPenilaian(){
        $dict_bank_set = DictBankSet::where('flag_publish', 1)->where('flag', 1)->where('delete_id', 0)->get();

        if(empty(Auth::user()->user_profile)) {
            return [];
        } else if(empty(Auth::user()->user_profile->profile_Profile_cawangan_log_active)) {
            return [];
        } else if(empty(Auth::user()->user_profile->profile_Profile_cawangan_log_active->gred)) {
            return [];
        } else  {
            $getUserGrade = Auth::user()->user_profile->profile_Profile_cawangan_log_active->gred;

            $grade_idGet = Grade::where('name', $getUserGrade)->first();
            $completed = 0;
            if(!$grade_idGet) {
                return [
                    'pass' => 0
                ];
            } else {
                $grade_id = $grade_idGet->id;
                $data['user'] = User::getPengguna(Auth::user()->user_profile->id);
                $data['pass'] = 1;
                if(count($dict_bank_set) > 0){
                    foreach($dict_bank_set as $dbs){
                        $penilaian_percentage = 0;
                        $penilaian_exist = $dbs->dictBankSetPenilaianUser;

                        if(!$penilaian_exist){
                            $grade_cat = $dbs->dictBankSetGradeCategoriesAll;
                            if($grade_cat){
                                $passGrade = 0;
                                foreach($grade_cat as $gc){
                                    $checkGradeAvailable = DictBankGrade::where('dict_bank_grades_categories_id', $gc->id)->where('grades_id', $grade_id)->first();
                                    if(!$checkGradeAvailable){
                                        $passGrade += 1;
                                    }else{
                                        $passGrade = 0;
                                        break;
                                    }
                                }

                                if($passGrade == 0){
                                    $createP = self::createNewPenilaian($dbs->id);
                                    if($createP){
                                        $data['penilaian_list'][$createP->id] = self::penilaianCollection($createP);
                                    }
                                }else{
                                    $data['penilaian_list'] = [];
                                }
                            }
                        }else{
                            $data['penilaian_list'][$penilaian_exist->id] = self::penilaianCollection($penilaian_exist);
                            if($penilaian_exist->status == 1) {
                                $completed = $completed + 1;
                            }
                        }
                    }
                    $data['completed'] = $completed;
                    return $data;
                }else{
                    return [
                        'pass' => 3
                    ];
                }
            }
        }
    }

    public static function createNewPenilaian($penilaian_id){
        $user_gred = Auth::user()->user_profile->profile_Profile_cawangan_log_active->gred;
        $model = new Penilaian;
        $model->profiles_id = Auth::user()->user_profile->id;
        $model->dict_bank_sets_id = $penilaian_id;
        $model->status = 0;
        $model->standard_gred = $user_gred;
        $model->actual_gred = Perkhidmatan::getActualGred(Auth::user()->nokp);

        $model->profiles_cawangans_logs_id = Auth::user()->user_profile->profile_Profile_cawangan_log_active->id;
        $model->jurusan_id = Perkhidmatan::where('nokp', Auth::user()->nokp)->where('flag', 1)->first()->kod_jurusan;

        $grade_id = Grade::where('name', $user_gred)->first()->id;
        $grade_c = DictBankGradeCategory::where('dict_bank_sets_id', $penilaian_id)->get();

        $gc_id = '';
        $g_id = '';

        foreach($grade_c as $gc){
            $dbg = DictBankGrade::where('dict_bank_grades_categories_id', $gc->id)->where('grades_id', $grade_id)->first();
            if($dbg){
                $gc_id = $gc->id;
                $g_id = $dbg->id;
                break;
            }
        }
        $model->dict_bank_grades_categories_id = $gc_id;
        $model->dict_bank_grades_id = $g_id;

        if($model->save()){
            self::scoreSetting($model);
            return $model;
        }else{
            return false;
        }
    }

    public static function scoreSetting($model){
        $dict_bank_set = $model->penilaianDictBankSet;

        $getStandardGred = Auth::user()->user_profile->profile_Profile_cawangan_log_active->gred;
        $grade_id = Grade::where('name', 'like', '%'.$getStandardGred.'%')->first()->id;

        $grade_cat = DB::connection('pgsql')->select("
            Select * from dict_bank_grades_categories
                dbgc join dict_bank_grades dbg on dbgc.id = dbg.dict_bank_grades_categories_id
                join dict_bank_sets dbs on dbgc.dict_bank_sets_id = dbs.id
            where dbs.id = $dict_bank_set->id
                    and dbg.grades_id = '".$grade_id."'
            limit 1
        ");

        if($dict_bank_set){
            $competencySet = $dict_bank_set->dictBankSetCompetencyScaleLvl;
            if($competencySet){
                foreach($competencySet as $cs){
                    $pcModel =  new PenilaiansCompetency;
                    $pcModel->penilaians_id = $model->id;
                    $pcModel->dict_bank_competency_types_scale_lvls_id = $cs->id;
                    $pcModel->status = 0;
                    if($pcModel->save()){
                        $items = DictBankSetsItem::where('dict_bank_sets_id', $dict_bank_set->id)->where('dict_bank_competency_types_scale_lvls_id', $pcModel->dict_bank_competency_types_scale_lvls_id)->where('dict_bank_grades_categories_id', $grade_cat[0]->dict_bank_grades_categories_id)->get();
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
                        }else{
                            $pcModel->delete();
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
            'id' => $penilaianModel->penilaianDictBankSet->id,
            'name' => $penilaianModel->penilaianDictBankSet->title,
            'year' => $penilaianModel->penilaianDictBankSet->dictBankSetYear->year,
            'current_tkh' => date('Y-m-d H:i:s'),
            'tkh_mula' => $penilaianModel->penilaianDictBankSet->tkh_mula,
            'tkh_tutup' => $penilaianModel->penilaianDictBankSet->tkh_tamat,
            'tkh_remain' => $date2->days.' Hari '.$date2->h.' Jam '.$date2->i.' Minit ',
            'status' => $penilaianModel->status,
            'penyelia' => $penilaianModel->penilaianPenyeliaProfiles ? [
                'profile_id' => $penilaianModel->penilaianPenyeliaProfiles->profile_Users->id,
                'name' => $penilaianModel->penilaianPenyeliaProfiles->profile_Users->name,
            ] : null,
            'jobgroup' => $penilaianModel->penilaianJobgroup ? [
                'id' => $penilaianModel->penilaianJobgroup->id,
                'name' => $penilaianModel->penilaianJobgroup->title_eng
            ] : null,
            'competencies' => self::penilaianCompetencyCollection($penilaianModel)
        ];

        return $data;
    }

    public static function penilaianCompetencyCollection($penilaianModel){
        $data = [];
        $competency = $penilaianModel->penilaianPenilaianCom;

        // echo '<pre>';
        // print_r($competency);
        // echo '</pre>';
        // die();
        if($competency){
            foreach($competency as $c){
                $total = count($c->penilaianCompetencyJawapanTotal);
                $notAns = count($c->penilaianCompetencyJawapanNotAns);
                $ans = count($c->penilaianCompetencyJawapanAns);

                echo $ans;
                $percentageLengkap = number_format((float)($ans/$total) * 100, 2, '.', '');
                $data[] = [
                    'id' => $c->id,
                    'name' => $c->penilaianCompetencyActualCom->dictBankCompetencyTypeScaleBridgeCompetency->name,
                    'total' => $total,
                    'notAns' => $notAns,
                    'ans' => $ans,
                    'status' => $c->status,
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

    public static function penilaianCalculate(PenilaiansCompetency $data){

    }
}
