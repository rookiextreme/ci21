<?php
namespace App\Http\Controllers\Segment\Pengguna\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Mykj\ListPegawai2;
use App\Models\Mykj\LJurusan;
use App\Models\Penilaian\DictBank\Set\DictBankSet;
use App\Models\Penilaian\Main\Penilaian;
use app\models\User;
use Illuminate\Http\Request;
use DB;
use Yajra\DataTables\DataTables;
use Auth;

class PenggunaDashboardPenggunaController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $data = Penilaian::checkPenilaian();

        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';
        // die();
        $jurusan = LJurusan::all();
        return view('segment.pengguna.dashboard.pengguna_dashboard', [
            'data' => $data,
            'jurusan' => $jurusan
        ]);
    }

    public function getPenyelia(Request $request){
        $nokp = $request->input('nokp');
        $gred = $request->input('gred');
        $jurusan = $request->input('jurusan');

        $extraQ = '';
        if($nokp){
            $extraQ .= "and (p.nama ilike '%".$nokp."%' OR p.nokp ilike '%".$nokp."%')";
        }

        if($gred){
            if($gred == 55){
                $extraQ .= "AND pk.kod_gred IN ('VU1','VU2','VU3','VU4','VU5','VU6','VU7','VK5','VK6','VK7')";
            }else{
                $extraQ .= "and pk.kod_gred ilike '%".$gred."%'";
            }

        }

        if($jurusan){
            $extraQ .= "and pk.kod_jurusan = '".$jurusan."'";
        }

        //will put after done
        // join list_pegawai2 lp2 on lp2.nokp = p.nokp

        $model = DB::connection('pgsqlmykj')->select("
            Select p.nama, p.nokp, pk.kod_gred, pk.kod_jurusan from peribadi p
                join perkhidmatan pk on p.nokp = pk.nokp
                join list_pegawai2 lp2 on lp2.nokp = p.nokp
            where
                pk.flag = 0 and pk.kod_klasifikasi = 'J' and p.nama IS NOT NULL
                ".$extraQ."
                LIMIT 3000
        ");

        return DataTables::of($model)
            ->setRowAttr([
                'data-nokp' => function($data) {
                    return $data->nokp;
                },
            ])
            ->addColumn('name', function($data){
                return strtoupper($data->nama);
            })
            ->addColumn('nokp', function($data){
                return strtoupper($data->nokp);
            })
            ->addColumn('jurusan', function($data){
                return strtoupper($data->kod_jurusan);
            })
            ->addColumn('gred', function($data){
                return strtoupper($data->kod_gred);
            })
            ->rawColumns(['active', 'action'])
            ->make(true);
    }

    public function tambah_kemaskini(Request $request){
        $nokp = $request->input('nokp');
        $penilaian_id = $request->input('penilaian_id');

        $getMaklumat = ListPegawai2::getMaklumatPegawai($nokp);

        if(!empty($getMaklumat)){
            try {
                $addOrDeletePenyelia = User::penyeliaCheck($penilaian_id, $nokp, $getMaklumat);

                return response()->json([
                    'success' => 1,
                ]);
            }catch (Exception $e){
                return response()->json([
                    'success' => 0,
                ]);
            }
        }else{
            return response()->json([
                'success' => 3,
            ]);
        }
    }

    public function getJobGroup(Request $request){
        $penilaian_id = $request->input('penilaian');
        $jurusan_id = $request->input('jurusan');


        $extraQ = '';
        if($jurusan_id){
            $extraQ .= "and dbjs.jurusan_id = '".$jurusan_id."'";
        }

        $model = DB::connection('pgsql')->select("
            select dbjs.* from dict_bank_grades_categories dbgc join
                dict_bank_grades dbg on dbgc.id = dbg.dict_bank_grades_categories_id
                join grades g on dbg.grades_id = g.id
                join dict_bank_jobgroup_sets dbjs on dbgc.id = dbjs.dict_bank_grades_categories_id
            where dbgc.dict_bank_sets_id = ".$penilaian_id."
            ".$extraQ."
            and g.name in ('".Auth::user()->user_profile->profile_Profile_cawangan_log_active->gred."')
        ");

        return DataTables::of($model)
            ->setRowAttr([
                'data-job-group-id' => function($data) {
                    return $data->id;
                },
            ])
            ->addColumn('title', function($data){
                return strtoupper($data->title_eng);
            })
            ->addColumn('jurusan', function($data){
                return strtoupper($data->jurusan_id);
            })
            ->rawColumns(['active', 'action'])
            ->make(true);
    }

    public function tambah_kemaskini_job_group(Request $request){
        $penilaian_id = $request->input('penilaian_id');
        $jobgroup_id = $request->input('jobgroup_id');

        $model = Penilaian::where('profiles_id', Auth::user()->user_profile->id)->where('dict_bank_sets_id', $penilaian_id)->first();
        $model->dict_bank_jobgroup_sets_id = $jobgroup_id;
        if($model->save()){
            return response()->json([
                'success' => 1,
            ]);
        }else{
            return response()->json([
                'success' => 2,
            ]);
        }
    }
}
