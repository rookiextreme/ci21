<?php

namespace App\Http\Controllers\Penyelaras;

use App\Http\Controllers\Controller;
use App\Models\Mykj\ListPegawai2;
use App\Models\Penilaian\Main\Penilaian;
use App\Models\Profiles\Profile;
use App\Models\Penilaian\DictBank\Set\DictBankSet;
use App\Models\Penilaian\Grade\DictBankGradeCategory;
use App\Models\Regular\AgencyHierarchy;
use App\Models\Regular\AgencyPenyelaras;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use stdClass;
use Yajra\DataTables\DataTables;

class PenyelarasController extends Controller
{
    //
    public function load_main_page(Request $request) {
        return view('segment.penyelaras.index');
    }

    public function load_all_penilaians(Request $request) {
        $userId = Auth::user()->id;
        $profileIds = Profile::where('users_id',$userId)->pluck('id')->all();
        $agencyIds = AgencyPenyelaras::where('user_id',$userId)->pluck('agency_id')->all();
        $agencies = AgencyHierarchy::whereIn('id',$agencyIds)->get();

        $waranCodes = array();
        foreach($agencies as $a) {
            $waranCodes[] = substr($a->waran_code,1,4).'0000000';
        }

    //  $penilaians = Penilaian::whereIn('penyelia_profiles_id',$profileIds)->pluck('dict_bank_sets_id')->all();

        $penilaians = array();

        $penilaians = DB::table('penilaians as p')->join('profiles_cawangan_logs as pcl', 'p.profiles_cawangans_logs_id','=','pcl.id')
                            ->select('p.*')
                            ->whereIn('pcl.cawangan', $waranCodes)
                            ->pluck('dict_bank_sets_id')->all();

        // if(!empty($waranCode)) {
        //     $count = 0;
        //     foreach($waranCode as $code) {
        //         if($count == 0) {
        //             $query = $query->where('profiles_cawangan_logs.bahagian', 'like', $code);
        //         } else {
        //             $query = $query->orWhere('profiles_cawangan_logs.bahagian', 'like', $code);
        //         }
        //         $count++;
        //     }

        //     $penilaians = $query->pluck('dict_bank_sets_id')->all();
        // }



        $model = DictBankSet::whereIn('id', $penilaians)->get();

            return DataTables::of($model)
                ->setRowAttr([
                    'data-bank-set-id' => function($data) {
                        return $data->id;
                    },
                    'data-bank-set-flag-id' => function($data) {
                        return $data->flag;
                    },
                    'data-bank-set-year' => function($data) {
                        return $data->dictBankSetYear->year;
                    }
                ])
                ->addColumn('name', function($data){
                    return strtoupper($data->title);
                 })
                // ->addColumn('tkh_mula', function($data){
                //     return strtoupper($data->tkh_mula);
                // })
                // ->addColumn('tkh_tamat', function($data){
                //     return strtoupper($data->tkh_tamat);
                // })
               ->addColumn('year', function($data){
                    return $data->dictBankSetYear->year;
               })
                ->rawColumns(['action'])
                ->make(true);


    }

    public function add_penyelaras(Request $request) {
        $no_ic = $request->input('no_ic');
        $idAgensi = $request->input('agency_id');
        $getMaklumat = ListPegawai2::getMaklumatPegawai($no_ic);

        try {
            $user = User::createPenyelaras($getMaklumat,$idAgensi);
            return response()->json([
               'success' => 1,
            ]);
        }catch (Exception $e){
            return response()->json([
                'success' => 0,
            ]);
        }
    }

    public function delete_penyelaras(Request $request) {
        $agencyId = $request->input('agency_id');
        $userId = $request->input('user_id');


        try {
            $models = AgencyPenyelaras::where('user_id',$userId)->where('agency_id',$agencyId)->get();

            foreach($models as $model) {
                $model->delete();
            }

            return response()->json([
               'success' => 1,
            ]);
        }catch (Exception $e){
            return response()->json([
                'success' => 0,
            ]);
        }


    }

    public function load_list_caw(Request $request){
        $bank_sets_id = $request->input('bank_sets_id');
        $year = $request->input('year');
        $cawangan = DB::table('penilaians as p')
                        ->join('profiles_cawangan_logs as pcl', 'p.profiles_cawangans_logs_id', 'pcl.id')
                        ->select('pcl.cawangan','pcl.cawangan_name')
                        ->where('p.dict_bank_sets_id',$bank_sets_id)
                        ->groupBy('pcl.cawangan','pcl.cawangan_name')
                        ->get();

        $results = array();

        foreach($cawangan as $caw) {
            $o = new stdClass();
            $o->bank_sets_id = $bank_sets_id;
            $o->year = $year;
            $o->waran_code = $caw->cawangan;
            $o->name = $caw->cawangan_name;
            $o->total = $this->count_detail($bank_sets_id,$caw->cawangan,$year);
            $o->draf= $this->calculate_draf($bank_sets_id);
            $o->finish = $this->calculate_finish($bank_sets_id);
            $o->complete = $this->calculate_complete($bank_sets_id);
            $o->noaction = $o->total - ($o->draf + $o->finish + $o->complete);
            $results[] = $o;
        }

        $model = collect($results);

        // return response()->json([
        //     'success' => 1,
        //     'data' => $results
        //  ]);

        return DataTables::of($model)
                ->setRowAttr([
                    'data-caw-waran-code' => function($data) {
                        return $data->waran_code;
                    },
                    'data-bank-sets-id' => function($data) {
                        return $data->bank_sets_id;
                    },
                    'data-year' => function($data) {
                        return $data->year;
                    }
                ])
                ->addColumn('name', function($data){
                    return strtoupper($data->name);
                 })
               ->addColumn('code', function($data){
                    return $data->waran_code;
               })
               ->addColumn('total_staff', function($data){
                    return $data->total;
                })
                ->addColumn('draf', function($data){
                    return $data->draf;
                })
                ->addColumn('finish', function($data){
                    return $data->finish;
                })
                ->addColumn('complete', function($data){
                    return $data->complete;
                })
                ->addColumn('no_action', function($data){
                    return $data->noaction;
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    public function load_list_staff(Request $request) {
        $bank_sets_id = $request->input('bank_sets_id');
        $waran_code = $request->input('waran_code');
        $year = $request->input('year');

        $model = $request->session()->get($bank_sets_id.'-'.$waran_code.'-'.$year);

        return DataTables::of($model)
                ->setRowAttr([
                    'data-nokp' => function($data) {
                        return $data->nokp;
                    }
                ])
                ->addColumn('name', function($data){
                    return strtoupper($data->nama);
                 })
               ->addColumn('grade', function($data){
                    return $data->kod_gred;
               })
               ->addColumn('icno', function($data){
                    return $data->nokp;
                })
                ->addColumn('course', function($data){
                    return $data->jurusan;
                })
                ->addColumn('section', function($data){
                    return $data->bahagian;
                })
                ->addColumn('status', function($data){
                    return $data->status;
                })
                ->make(true);
    }

    private function load_list_detail($bank_sets_id,$caw_waran,$year) {
        $grade_categories = DictBankGradeCategory::where('dict_bank_sets_id',$bank_sets_id)->get();
        $grade_list = array();
        foreach($grade_categories as $gc) {
            foreach($gc->dictBankGradeCategoryGetGrade as $g) {
                $grade_list[] = $g->dictBankGradeGrade->name;
            }
        }

        $counter = 0;
        $grades_str = "";
        foreach($grade_list as $key => $val) {
            if($counter == 0)
                $grades_str .= "'".$val."'";
            else
                $grades_str .= ",'".$val."'";
                $counter++;
        }

        $waran_split = "0".substr($caw_waran,0,4)."%";

        $raws = DB::connection('pgsqlmykj')
                        ->select("SELECT x.nokp,a.nama,
                        k.kod_gred, x.kod_waran FROM penempatanx x
                        JOIN perkhidmatan k ON k.nokp = x.nokp
                        JOIN peribadi a ON x.nokp = a.nokp
                        where extract(year from x.tkh_masuk) <= ".$year."
                        AND extract(year from k.tkh_lantik) <= ".$year."
                        AND a.kod_status_aktif = '1'
                        AND k.kod_gred in (".$grades_str.")
                        AND x.kod_waran LIKE '".$waran_split."'
                        AND k.kod_kumpulan in ('1','2','3','4')
                        group by x.nokp, k.kod_gred, a.nama, x.kod_waran
                        order by x.nokp desc");

        $staffs = array();

        foreach($raws as $key1 => $val1) {
            $accept = false;
            // first filter
            $filter1 = DB::connection('pgsqlmykj')
                        ->select("SELECT p.nokp, p.kod_gred, j.jurusan FROM perkhidmatan p LEFT JOIN l_jurusan j ON p.kod_jurusan = j.kod_jurusan
                        WHERE p.nokp='".$val1->nokp."' AND extract(year from p.tkh_lantik) <= ".$year."
                        order by p.id_perkhidmatan desc");

            if(!empty($filter1)) {
                if($filter1[0]->kod_gred == $val1->kod_gred) {
                    $accept = true;
                }
            }
            //second filter
            if($accept) {
                $filter2 = DB::connection('pgsqlmykj')->select("SELECT x.nokp,x.kod_waran,p.waran_pej
                FROM penempatanx x JOIN l_waran_pej p ON x.kod_waran = p.kod_waran_pej
                WHERE x.nokp = '".$val1->nokp."' AND extract(year from x.tkh_masuk) <= ".$year." ORDER BY x.id_penempatan desc");

                if(empty($filter2)) {
                    $accept = false;
                } else {
                    if($filter2[0]->kod_waran == $val1->kod_waran) {
                        $accept = true;
                    } else {
                        $accept = false;
                    }
                }

                if($accept) {
                    $status_results = DB::connection('pgsql')->select("SELECT p.status FROM penilaians p
                    JOIN profiles s ON p.profiles_id = s.id
                    JOiN users u ON s.users_id = u.id
                    WHERE u.nokp = ".$val1->nokp);

                    $a = new stdClass();
                    $a->nama = $val1->nama;
                    $a->nokp = $val1->nokp;
                    $a->jurusan = $filter1[0]->jurusan;
                    $a->gred = $val1->kod_gred;
                    $a->bahagian = $filter2[0]->waran_pej;

                    if(empty($status_results)) {
                        $a->status = 0;
                    } else {
                        $a->status = $status_results[0]->status + 1;
                    }

                    $staffs[] = $a;
                }
            }
        }

        $model = collect($staffs);

        Session::put($bank_sets_id.'-'.$caw_waran.'-'.$year,$model);

        return $model->count();
    }

    private function count_detail($bank_sets_id,$caw_waran,$year) {
        $grade_categories = DictBankGradeCategory::where('dict_bank_sets_id',$bank_sets_id)->get();
        $grade_list = array();
        foreach($grade_categories as $gc) {
            foreach($gc->dictBankGradeCategoryGetGrade as $g) {
                $grade_list[] = $g->dictBankGradeGrade->name;
            }
        }

        //DB::enableQueryLog();
        //l_waran_pej p ON x.kod_waran = p.kod_waran_pej
        $total = DB::connection('pgsqlmykj')->table('peribadi as a')
            ->join('penempatanx as b','a.nokp','b.nokp')
            ->join('perkhidmatan as c','a.nokp','c.nokp')
            ->leftJoin('l_jurusan as j','c.kod_jurusan', 'j.kod_jurusan')
            ->join('l_waran_pej as p','b.kod_waran', 'p.kod_waran_pej')
            ->select('a.nama','a.nokp','c.kod_gred','j.jurusan','p.waran_pej')
            ->where('a.kod_status_aktif', '1')
            ->where('b.flag',1)
            ->where('b.ref_id',0)
            ->where('c.flag', 1)
            ->where('b.kod_waran', 'like', '0'.substr($caw_waran,0,4).'%')
            ->whereIn('c.kod_kumpulan', array('1', '2', '3', '4'))
            // ->where('c.kod_gred','<>','')
            // ->where('c.kod_gred','<>','0')
            // ->whereNotNull('c.kod_gred')
            ->whereIn('c.kod_gred',$grade_list)
            ->where(DB::raw('extract(year from a.tkh_masuk) <= '.$year))
            ->get();

        //dd(DB::getQueryLog());

        $total->each(function ($item, $key) {
            $status_results = DB::connection('pgsql')->select("SELECT p.status FROM penilaians p
                    JOIN profiles s ON p.profiles_id = s.id
                    JOiN users u ON s.users_id = u.id
                    WHERE u.nokp = ".$item->nokp);
             if(empty($status_results)) {
                $item->status = 0;
            } else {
                $item->status = $status_results[0]->status + 1;
            }
        });

        Session::put($bank_sets_id.'-'.$caw_waran.'-'.$year,$total);

        return $total->count;

    }

    private function calculate_finish($bank_sets_id) {
        $count = Penilaian::where('dict_bank_sets_id',$bank_sets_id)
                    ->where('status',1)->count();

        return $count;
    }

    private function calculate_complete($bank_sets_id) {
        $count = Penilaian::where('dict_bank_sets_id',$bank_sets_id)
                    ->where('status',2)->count();

        return $count;
    }

    private function calculate_draf($bank_sets_id) {
        $count = Penilaian::where('dict_bank_sets_id',$bank_sets_id)
                    ->where('status',0)->count();

        return $count;
    }

    public function load_detail(Request $request) {
        $bank_sets_id = $request->input('bank_sets_id');
        $caw_waran = $request->input('kod_waran');
        $year = $request->input('year');

        $grade_categories = DictBankGradeCategory::where('dict_bank_sets_id',$bank_sets_id)->get();
        $grade_list = array();
        foreach($grade_categories as $gc) {
            foreach($gc->dictBankGradeCategoryGetGrade as $g) {
                $grade_list[] = $g->dictBankGradeGrade->name;
            }
        }

        //DB::enableQueryLog();
        $total = DB::connection('pgsqlmykj')->table('peribadi as a')
            ->join('penempatanx as b','a.nokp','b.nokp')
            ->join('perkhidmatan as c','a.nokp','c.nokp')
            ->join('l_jawatan as d','c.kod_jawatan', 'd.kod_jawatan')
            ->join('l_waran_pej as p','b.kod_waran','')
            ->leftJoin()
            ->where('a.kod_status_aktif', '1')
            ->where('b.flag',1)
            ->where('b.ref_id',0)
            ->where('c.flag', 1)
            ->where('b.kod_waran', 'like', '0'.substr($caw_waran,0,4).'%')
            ->whereIn('c.kod_kumpulan', array('1', '2', '3', '4'))
            // ->where('c.kod_gred','<>','')
            // ->where('c.kod_gred','<>','0')
            // ->whereNotNull('c.kod_gred')
            ->whereIn('c.kod_gred',$grade_list)
            ->where(DB::raw('extract(year from a.tkh_masuk) <= '.$year))
            ->get();

        //dd(DB::getQueryLog());

        return $total;
    }
}
