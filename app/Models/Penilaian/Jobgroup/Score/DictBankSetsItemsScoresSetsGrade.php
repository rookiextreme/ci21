<?php
namespace App\Models\Penilaian\Jobgroup\Score;

use App\Models\Penilaian\Grade\DictBankGradeCategory;
use App\Models\Penilaian\Jobgroup\Set\DictBankJobgroupSet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class DictBankSetsItemsScoresSetsGrade extends Model{
    public $table = 'dict_bank_jobgroup_sets_items_scores_sets_grades';

    public function dictBankJobgroupScoreGradeDictBankItem(){
        return $this->hasOne('App\Models\Penilaian\Jobgroup\Set\DictBankJobgroupSetsItem', 'id', 'dict_bank_jobgroup_sets_items_id');
    }

    public function dictBankJobgroupScoreGradeDictBankGrade(){
        return $this->hasOne('App\Models\Penilaian\Grade\DictBankGrade', 'id', 'dict_bank_grades_id');
    }

    public static function createUpdateItemScoreList(DictBankJobgroupSet $job_group){
        $penilaian_id = $job_group->dict_bank_sets_id;
        $jbItem = $job_group->dictBankJobgroupSetItems;
        if($jbItem){
            $score_id_arr = [];
            foreach($jbItem as $jItem){
                $itemScore = $jItem->dictBankJobgroupSetItemsScore;
                array_push($score_id_arr, $jItem->id);
                if(count($itemScore) == 0){
                    self::createGradeScore($jItem->id, $job_group->dict_bank_grades_categories_id, $job_group->id);
                }else{
                    self::updateGradeScore($jItem->id, $job_group->dict_bank_grades_categories_id, $job_group->id);
                }
            }

            if(!empty($score_id_arr)){
                self::whereNotIn('dict_bank_jobgroup_sets_items_id', $score_id_arr)->where('dict_bank_jobgroup_sets_id', $job_group->id)->delete();
            }
        }
    }

    public static function createGradeScore($item_id, $grade_category_id, $jobgroup_id){
        $dictCatGrade = DictBankGradeCategory::find($grade_category_id);
        $grades = $dictCatGrade->dictBankGradeCategoryGetGrade;

        foreach($grades as $g){
            $model = new self;
            $model->dict_bank_jobgroup_sets_id = $jobgroup_id;
            $model->dict_bank_jobgroup_sets_items_id = $item_id;
            $model->dict_bank_grades_id = $g->id;
            $model->score = 0;
            $model->flag = 1;
            $model->delete_id = 0;
            $model->save();
        }

        return $item_id;
    }

    public static function updateGradeScore($item_id, $grade_category_id, $jobgroup_id){
        $check = self::where('dict_bank_jobgroup_sets_items_id', $item_id)->where('flag', 1)->where('delete_id', 0)->first();
        if(!$check){
            $process = self::createGradeScore($item_id, $grade_category_id, $jobgroup_id);
        }
        return $item_id;
    }

    public static function getLatestScoreSet(DictBankJobgroupSet $job_group){
        $data = [];
        $penilaian_id = $job_group->dict_bank_sets_id;
        $jbItem = $job_group->dictBankJobgroupSetItems;
        $data['penilaian_id'] = $penilaian_id;
        $data['grade_category_name'] = $job_group->dictBankJobgroupSetDictGradeCategory->name;
        $data['item']['main'] = [
            'id' => $job_group->id,
            'title_eng' => $job_group->title_eng,
        ];
        $data['grade_categories'] = self::getGradeCategories($job_group->dictBankJobgroupSetDictGradeCategory->dictBankGradeCategoryGetGrade);
        if($jbItem){
            foreach($jbItem as $jItem){
                $data['item']['main']['list'][] = [
                    'id' => $jItem->id,
                    'name' => $jItem->dictBankJobgroupSetsItemDictBankSetsItem->title_eng,
                    'scoreset' => self::getLatestScore($jItem->dictBankJobgroupSetItemsScore)
                ];
            }
        }

        return $data;
    }

    public static function getLatestScore($items){
        $data = [];
        if(count($items) > 0){
            foreach($items as $score){
                $data[] = [
                    'id' => $score->id,
                    'grade_id' => $score->dict_bank_grades_id,
                    'score' => $score->score
                ];
            }
        }

        $mainList = array_column($data, 'grade_id');
        array_multisort($mainList, SORT_ASC, $data);
        return $data;
    }

    public static function getGradeCategories($categories){
        $data = [];
        foreach($categories as $c){
            $data[] = [
                'id' => $c->id,
                'name' => $c->dictBankGradeGrade->name
            ];
        }

        $mainList = array_column($data, 'id');
        array_multisort($mainList, SORT_ASC, $data);
        return $data;
    }

    public static function updateAllScore(Request $request){
        $scoreArr = json_decode($request->input('scoreArr'));

        foreach($scoreArr as $sa){
            $set_item_id = $sa[0];
            $score_id = $sa[1];
            $score = $sa[2];

            $model = self::find($score_id);
            $model->score = $score;
            $model->save();
        }

        return 1;
    }
}
