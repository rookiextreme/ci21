<?php
namespace App\Http\Controllers\Segment\Pelaporan;

use App\Http\Controllers\Controller;
use App\Models\Mykj\LJurusan;
use App\Models\Penilaian\DictBank\Set\DictBankSet;
use App\Models\Penilaian\Grade\DictBankGrade;
use App\Models\Penilaian\Main\Penilaian;
use App\Models\Regular\Grade;
use App\Models\Regular\Year;
use Illuminate\Http\Request;

class PelaporanController extends Controller{
    public function index(){
        return view('segment.pelaporan.list');
    }

    public function analisis_jurang_standard(Request $request, $trigger){
        $year = Year::all();
        $jurusan = LJurusan::all();
        $gred = Grade::all();

        $search_tahun = '';
        $search_penilaian = '';
        $search_kumpulan = '';
        $search_gred = '';
        $search_jurusan = '';
        $search_group = '';
        $search_kompetensi = '';

        $data = [];
        if($request->post()){
            $data = $this->analisis_jurang_standard_calculate($request, $trigger);
            $search_tahun = $request->input('search_tahun');
            $search_penilaian = $request->input('search_penilaian');
            $search_gred = $request->input('search_gred');
            $search_jurusan = $request->input('search_jurusan');
            $search_kumpulan = $request->input('search_kumpulan');
            $search_group = $request->input('search_job_group');
            $search_kompetensi = $request->input('search_kompetensi');
        }

        return view('segment.pelaporan.analisis_jurang_standard',  [
            'year' => $year,
            'jurusan' => $jurusan,
            'gred' => $gred,
            'data' => $data,
            'search_tahun' => $search_tahun,
            'search_penilaian' => $search_penilaian,
            'search_kumpulan' => $search_kumpulan,
            'search_gred' => $search_gred,
            'search_jurusan' => $search_jurusan,
            'search_group' => $search_group,
            'search_kompetensi' => $search_kompetensi,
            'trigger' => $trigger
        ]);
    }

    public function analisis_jurang_standard_search(Request $request){
        $type = $request->input('type');

        $data = [];

        if($type == 1){
            $year = $request->input('year');
            $dict_bank_sets = DictBankSet::where('years_id', $year)->where('flag_publish', 1)->where('flag', 1)->where('delete_id', 0)->get();

            if(count($dict_bank_sets) > 0){
                foreach($dict_bank_sets as $dbs){
                    $data[] = [
                        'id' => $dbs->id,
                        'title' => $dbs->title
                    ];
                }
            }
        }else if($type == 2){
            $penilaian_id = $request->input('penilaian_id');
            $dict_bank_sets = DictBankSet::find($penilaian_id);

            $kumpulan_gred = $dict_bank_sets->dictBankSetGradeCategoriesAll;

            if($kumpulan_gred){
                foreach($kumpulan_gred as $kg){
                    $data['kumpulan_with_grade'][] = [
                        'id' => $kg->id,
                        'name' => $kg->name,
                        'greds' => $this->getCategoryGrade($kg->id),
                    ];
                }
            }

            $job_group = $dict_bank_sets->dictBankSetDictJobgroupSet;

            if(count($job_group) > 0){
                foreach($job_group as $jg){
                    $data['job_group'][] = [
                        'id' => $jg->id,
                        'title' => $jg->title_eng
                    ];
                }
            }

            $kompetensi = $dict_bank_sets->dictBankSetCompetencyScaleLvl;

            if(count($kompetensi) > 0){
                foreach($kompetensi as $k){
                    $data['kompetensi'][] = [
                        'id' => $k->id,
                        'title' => $k->dictBankCompetencyTypeScaleBridgeCompetency->name
                    ];
                }
            }

            // echo '<pre>';
            // print_r($data);
            // echo '</pre>';
            // die();
        }


        return response()->json([
            'success' => 1,
            'data' => $data,
            'type' => $type
        ]);
    }

    public function getCategoryGrade($category_id){
        $data = [];

        $model = DictBankGrade::where('dict_bank_grades_categories_id', $category_id)->get();
        if(count($model) > 0){
            foreach($model as $m){
                $data[] = [
                    'id' => $m->id,
                    'gred_name' => $m->dictBankGradeGrade->name
                ];
            }
        }

        return $data;
    }

    public function analisis_jurang_standard_calculate(Request $request, $trigger){
        $search_tahun = $request->input('search_tahun');
        $dict_bank_sets_id = $request->input('search_penilaian');
        $dict_bank_gred_id = $request->input('search_gred');
        $search_jurusan = $request->input('search_jurusan');
        $dict_bank_grades_categories_id = $request->input('search_kumpulan');
        $dict_bank_job_group_sets_id = $request->input('search_job_group');
        $dict_bank_competency_type_scale_lvl_id = $request->input('search_kompetensi');

        $data = [];

        $labelDefault = $this->getDictBankItemsLabel($dict_bank_sets_id);

        $data['title'] = $labelDefault['penilaian_title'];
        $data['labelcount'] = count($labelDefault['label']);
        $data['label'] = $labelDefault['label'];
        $data['results'] = $labelDefault['results'];
        $data['totalP'] = 0;

        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';
        // die();
        $penilaian = Penilaian::where('dict_bank_sets_id', $dict_bank_sets_id);

        if($dict_bank_grades_categories_id != ''){
            $penilaian->where('dict_bank_grades_categories_id', $dict_bank_grades_categories_id);
        }

        if($search_jurusan != ''){
            $penilaian->where('jurusan_id', $search_jurusan);
        }

        if($dict_bank_gred_id != ''){
            // echo $dict_bank_gred_id;
            // die();
            $penilaian->where('dict_bank_grades_id', $dict_bank_gred_id);
        }

        if($dict_bank_job_group_sets_id != ''){
            $penilaian->where('dict_bank_jobgroup_sets_id', $dict_bank_job_group_sets_id);
        }

        if($dict_bank_competency_type_scale_lvl_id !== ''){
            $penilaian->with(['penilaianPenilaianComWithAnswers' => function ($q) use ($dict_bank_competency_type_scale_lvl_id) {
                $q->where('dict_bank_competency_types_scale_lvls_id', $dict_bank_competency_type_scale_lvl_id);
            }]);
        }

        $p = $penilaian->where('status', 2)->get();

        if(count($p) > 0){
            foreach($p as $pc){
                $data['totalP'] += 1;
                $penyelia_update = $pc->penyelia_update;
                $comAns = $pc->penilaianPenilaianComWithAnswers;

                if(count($comAns) > 0){
                    if($penyelia_update == 0){
                        foreach($comAns as $ca){
                            $allAns = $ca->penilaianCompetencyAvg;
                            if(count($allAns) > 0){
                                foreach($allAns as $a){
                                    $items_id = $a->dict_bank_sets_items_id;
                                    if($trigger == 0){
                                        $dev_gap = $a->dev_gap;
                                    }else{
                                        $dev_gap = $a->actual_dev_gap == null ? 0 : $a->actual_dev_gap;
                                    }

                                    if(array_key_exists($items_id, $data['label'])){
                                        if($dev_gap > 0){
                                            $data['results'][$items_id]['pos'] += 1;
                                        }else if($dev_gap < 0){
                                            $data['results'][$items_id]['neg'] += 1;
                                        }
                                    }
                                }
                            }
                        }
                    }else if($penyelia_update == 1){
                        foreach($comAns as $ca){
                            $allAns = $ca->penilaianCompetencyPenyeliaAvg;
                            if(count($allAns) > 0){
                                foreach($allAns as $a){
                                    $items_id = $a->dict_bank_sets_items_id;
                                    if($trigger == 0){
                                        $dev_gap = $a->dev_gap;
                                    }else{
                                        $dev_gap = $a->actual_dev_gap == null ? 0 : $a->actual_dev_gap;
                                    }
                                    // echo '<pre>';
                                    // print_r($data);
                                    // echo '</pre>';
                                    if(array_key_exists($items_id, $data['label'])){
                                        if($dev_gap > 0){
                                            $data['results'][$items_id]['pos'] += 1;
                                            $data['results'][$items_id]['totalP'] += 1;
                                        }else if($dev_gap < 0){
                                            $data['results'][$items_id]['neg'] += 1;
                                            $data['results'][$items_id]['totalN'] += 1;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';
        // die();
        return $data;
    }

    public function getDictBankItemsLabel($dict_bank_sets_id){

        $dict_bank_set = DictBankSet::find($dict_bank_sets_id);
        $items = $dict_bank_set->dictBankSetDictBankSetsItem;

        $data = [];
        $data['penilaian_title'] = $dict_bank_set->title;
        if(count($items) > 0){
            foreach($items as $i){
                $data['label'][$i->id] = $i->title_eng;
                $data['results'][$i->id] = [
                    'pos' => 0,
                    'neg' => 0,
                    'totalP' => 0,
                    'totalN' => 0
                ];
            }
        }
        ksort($data['label']);
        ksort($data['results']);

        return $data;
    }

    //For analisis graph
    public function analisis_jurang_standard_graph(Request $request, $trigger){
        $year = Year::all();
        $jurusan = LJurusan::all();
        $gred = Grade::all();

        $search_tahun = '';
        $search_penilaian = '';
        $search_kumpulan = '';
        $search_gred = '';
        $search_jurusan = '';
        $search_group = '';
        $search_kompetensi = '';

        $data = [];
        if($request->post()){
            $data = $this->analisis_jurang_standard_calculate($request, $trigger);

            $data['positive'] = [];
            foreach($data['results'] as $r){
                $data['positive'][] = $r['totalP'];
                $data['negative'][] = $r['totalN'];
            }

            // echo '<pre>';
            // print_r($data);
            // echo '</pre>';
            // die();
            $search_tahun = $request->input('search_tahun');
            $search_penilaian = $request->input('search_penilaian');
            $search_gred = $request->input('search_gred');
            $search_jurusan = $request->input('search_jurusan');
            $search_kumpulan = $request->input('search_kumpulan');
            $search_group = $request->input('search_job_group');
            $search_kompetensi = $request->input('search_kompetensi');
        }

        return view('segment.pelaporan.analisis_jurang_standard_graf',  [
            'year' => $year,
            'jurusan' => $jurusan,
            'gred' => $gred,
            'data' => $data,
            'search_tahun' => $search_tahun,
            'search_penilaian' => $search_penilaian,
            'search_kumpulan' => $search_kumpulan,
            'search_gred' => $search_gred,
            'search_jurusan' => $search_jurusan,
            'search_group' => $search_group,
            'search_kompetensi' => $search_kompetensi,
            'trigger' => $trigger
        ]);
    }
}
