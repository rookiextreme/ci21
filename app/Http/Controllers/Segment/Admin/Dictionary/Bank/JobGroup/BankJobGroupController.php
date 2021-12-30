<?php
namespace App\Http\Controllers\Segment\Admin\Dictionary\Bank\JobGroup;

use App\Http\Controllers\Controller;
use App\Models\Mykj\LJurusan;
use App\Models\Penilaian\DictBank\Set\DictBankSetsItem;
use App\Models\Penilaian\Grade\DictBankGradeCategory;
use App\Models\Penilaian\Jobgroup\Set\DictBankJobgroupSet;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BankJobGroupController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($penilaian_id){
        return view('segment.admin.dictionarybank.jobgroup.index', [
            'penilaian_id' => $penilaian_id,
        ]);
    }

    public function job_group_list($penilaian_id){
        $model = DictBankJobgroupSet::where('delete_id', 0)->where('dict_bank_sets_id', $penilaian_id)->get();

        return DataTables::of($model)
            ->setRowAttr([
                'data-job-group-id' => function($data) {
                    return $data->id;
                },
                'data-job-group-flag-id' => function($data) {
                    return $data->flag;
                },
            ])
            ->addColumn('kumpulan', function($data){
                return strtoupper($data->dictBankJobgroupSetDictGradeCategory->name);
            })
            ->addColumn('jurusan', function($data){
                return $data->dictBankJobgroupSetJurusan ? strtoupper($data->dictBankJobgroupSetJurusan->jurusan) : 'Tiada Jurusan';
            })
            ->addColumn('title_eng', function($data){
                return strtoupper($data->title_eng);
            })
            ->addColumn('active', function($data){
                return strtoupper($data->name);
            })

            ->rawColumns(['active', 'action'])
            ->make(true);
    }

    public function job_group_tambah(Request $request){
        $model = new DictBankJobgroupSet;
        $process = $model->createAndUpdate($request);
        return response()->json($process);
    }

    public function job_group_get_record(Request $request){
        $process = DictBankJobgroupSet::getRecord($request->input('grade_id'));

        $data = [];
        if($process){
            $data = [
                'success' => 1,
                'data' => [
                    'name' => $process->name
                ]
            ];
        }
        return response()->json($data);
    }

    public function job_group_activate(Request $request){
        $model = new DictBankJobgroupSet;
        $process = $model->rekodActivate($request->input('job_group_id'));

        return response()->json($process);
    }

    public function job_group_delete(Request $request){
        $job_group_id = $request->input('job_group_id');
        $model = DictBankJobgroupSet::find($job_group_id);
        $model->delete_id = 1;
        if($model->save()){
            return response()->json([
                'success' => 1
            ]);
        }
    }

    public function job_group_insert_update_page($penilaian_id, $job_group_id = false){
        $jurusan = LJurusan::all();
        $grade_categories = DictBankGradeCategory::where('dict_bank_sets_id', $penilaian_id)->where('flag', 1)->where('delete_id', 0)->get();

        if($job_group_id){
            $model = DictBankJobgroupSet::getRecord($job_group_id);
            $groupData = DictBankJobgroupSet::groupData($model);
        }

        return view('segment.admin.dictionarybank.jobgroup.insertupdate', [
            'penilaian_id' => $penilaian_id,
            'jurusan' => $jurusan,
            'grade_categories' => $grade_categories,
            'groupData' => $groupData ?? [],
            'job_group_sets_id' => $job_group_id ?? ''
        ]);
    }

    public function job_group_jurusan_items(Request $request){
        $jurusan = $request->input('jurusan');
        $penilaian_id = $request->input('penilaian_id');
        $job_group_id = $request->input('job_group_id');

        $model = DictBankJobgroupSet::jurusanItem($penilaian_id, $jurusan, $job_group_id);

        return response()->json([
            'data' => $model
        ]);
    }

    public function job_group_insert_update_tambah(Request $request){
        $model = new DictBankJobgroupSet;
        $process = $model->createUpdate($request);
        return response()->json($process);
    }
}
