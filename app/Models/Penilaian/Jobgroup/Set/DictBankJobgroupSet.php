<?php
namespace App\Models\Penilaian\Jobgroup\Set;

use App\Http\Controllers\Segment\Admin\Dictionary\Bank\JobGroup\BankJobGroupController;
use App\Models\Penilaian\DictBank\Set\DictBankSetsItem;
use App\Models\Penilaian\Jobgroup\Score\DictBankJobgroupSetsItemsScoresSetsGrade;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class DictBankJobgroupSet extends Model{
    public function dictBankJobgroupSetProfile(){
        return $this->hasOne('App\Models\Profiles\Profile', 'id', 'profiles_id');
    }

    public function dictBankJobgroupSetYear(){
        return $this->hasOne('App\Models\Regular\Year', 'id', 'years_id');
    }

    public function dictBankJobgroupSetJurusan(){
        return $this->hasOne('App\Models\Mykj\LJurusan', 'kod_jurusan', 'jurusan_id');
    }

    public function dictBankJobgroupSetDictGradeCategory(){
        return $this->hasOne('App\Models\Penilaian\Grade\DictBankGradeCategory', 'id', 'dict_bank_grades_categories_id');
    }

    public function dictBankJobgroupSetDictBankSet(){
        return $this->hasOne('App\Models\Penilaian\DictBank\Set\DictBankSet', 'id', 'dict_bank_sets_id');
    }

    public function dictBankJobgroupSetItems(){
        return $this->hasMany('App\Models\Penilaian\Jobgroup\Set\DictBankJobgroupSetsItem', 'dict_bank_jobgroup_sets_id', 'id')->where('flag', 1)->where('delete_id', 0);
    }

    public function createUpdate(Request $request){
        $job_group_set_name_eng = $request->input('job_group_set_name_eng');
        $job_group_set_name_mal = $request->input('job_group_set_name_mal');
        $job_group_set_desc_eng = $request->input('job_group_set_desc_eng');
        $job_group_set_desc_mal = $request->input('job_group_set_desc_mal');
        $job_group_set_grade_category = $request->input('job_group_set_grade_category');
        $job_group_set_items = json_decode($request->input('job_group_set_items'));
        $job_group_set_jurusan = $request->input('job_group_set_jurusan');
        $trigger = $request->input('trigger');
        $penilaian_id = $request->input('penilaian_id');
        $job_group_id = $request->input('job_group_id');

        if($trigger == 0){
            $checkDup = self::getDuplicate($job_group_set_name_eng);
            $model = self::getRecord();
            $model->flag = 1;
            $model->delete_id = 0;
            $model->dict_bank_sets_id = $penilaian_id;
        }else{
            $checkDup = self::getDuplicate($job_group_set_name_eng, $job_group_id);
            $model = self::getRecord($job_group_id);
        }

        if($checkDup){
            return [
                'success' => 2
            ];
        }

        $model->jurusan_id = $job_group_set_jurusan;
        $model->dict_bank_grades_categories_id = $job_group_set_grade_category;
        $model->title_eng = $job_group_set_name_eng;
        $model->title_mal = $job_group_set_name_mal;
        $model->desc_eng = $job_group_set_desc_eng;
        $model->desc_mal = $job_group_set_desc_mal;

        if($model->save()){
            $this->createUpdateJobGroupItem($trigger, $job_group_set_items, $model->id);
            return [
                'success' => 1,
                'data' => [
                    'trigger' => $trigger
                ]
            ];
        }else{
            return [
                'success' => 0,
            ];
        }
    }

    public function createUpdateJobGroupItem($trigger, $items, $job_group_id){
        if($trigger == 0){
            $model = new DictBankJobgroupSetsItem;
            foreach($items as $i){
                $model->dict_bank_jobgroup_sets_id = $job_group_id;
                $model->dict_bank_sets_items_id = $i;
                $model->flag = 1;
                $model->delete_id = 0;
                $model->save();
            }
        }else{
            //Deleting Score Set if available before updating anything
            $checkDelete = DictBankJobgroupSetsItem::where('dict_bank_jobgroup_sets_id', $job_group_id)->whereNotIn('dict_bank_sets_items_id', $items)->get();

            if(count($checkDelete) > 0){
                foreach($checkDelete as $cd){
                    DictBankJobgroupSetsItemsScoresSetsGrade::where('dict_bank_jobgroup_sets_items_id', $cd->id)->delete();
                    $cd->delete();
                }
            }

            foreach($items as $i){
                $checkItem = DictBankJobgroupSetsItem::where('dict_bank_jobgroup_sets_id', $job_group_id)->where('dict_bank_sets_items_id', $i)->first();

                if(!$checkItem){
                    $model = new DictBankJobgroupSetsItem;
                    $model->dict_bank_jobgroup_sets_id = $job_group_id;
                    $model->dict_bank_sets_items_id = $i;
                    $model->flag = 1;
                    $model->delete_id = 0;
                    $model->save();
                }
            }
        }
    }

    public static function getRecord($id = false) : self{
        if(!$id){
            $model = new self;
        }else{
            $model = self::find($id);
        }

        return $model;
    }

    public static function getDuplicate($nama, $id = false): bool{
        if(!$id){
            $model = self::where('title_eng', 'ilike', '%'.$nama.'%')->where('delete_id', 0)->count();
        }else{
            $model = self::where('title_eng', 'ilike', '%'.$nama.'%')->where('id', '!=', $id)->where('delete_id', 0)->count();
        }


        return (bool)$model;
    }

    public function rekodActivate($id){
        $model = self::getRecord($id);
        $model->flag = $model->flag == 0 ? 1 : 0;

        if($model->save()){
            return [
                'success' => 1,
                'data' => [
                    'id' => $model->id,
                    'flag' => $model->flag
                ]
            ];
        }
    }

    public static function jurusanItem($penilaian_id, $jurusan, $job_group_id = ''){
        $data = [];
        $item = DictBankSetsItem::where('dict_bank_sets_id', $penilaian_id)->where('jurusan_id', $jurusan)->where('flag', 1)->where('delete_id', 0)->get();

        if(count($item) > 0){
            $data['count'] = count($item);
            foreach($item as $i){
                $data['items'][] = [
                    'title' => $i->title_eng,
                    'id' => $i->id,
                    'checked' => 0
                ];
            }
            if($job_group_id){
                $model = self::find($job_group_id);
                $items = $model->dictBankJobgroupSetItems;
                if($items){
                    foreach ($items as $i){
                        $item_id = $i->dict_bank_sets_items_id;
                        if(in_array($item_id, array_column($data['items'], 'id'))){
                            foreach($data['items'] as $dk => $dv){
                                if($dv['id'] == $item_id){
                                    $data['items'][$dk]['checked'] = 1;
                                }
                            }
                        }
                    }
                }
            }
        }

        return $data;
    }
    public static function groupData(self $model){
        $data = [];

        $data['main'] = [
            'jurusan' => $model->jurusan_id,
            'grade_categories' => $model->dict_bank_grades_categories_id,
            'title_eng' => $model->title_eng,
            'title_mal' => $model->title_mal,
            'desc_eng' => $model->desc_eng,
            'desc_mal' => $model->desc_mal,
            'items' => self::getAnsweredItems($model),
        ];

        return $data;
    }

    public static function getAnsweredItems(self $model){
        $data = [];

        $mainItem = self::jurusanItem($model->dict_bank_sets_id, $model->jurusan_id, $model->id);

        $items = $model->dictBankJobgroupSetItems;
        if($items){
           foreach ($items as $i){
               if(array_key_exists($i->dict_bank_sets_items_id, $mainItem)){
                   $mainItem[$i->dict_bank_sets_items_id]['checked'] = 1;
               }
           }
            $data = $mainItem;
        }
        return $data;
    }
}
