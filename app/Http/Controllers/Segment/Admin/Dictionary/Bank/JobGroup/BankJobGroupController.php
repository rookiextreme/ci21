<?php
namespace App\Http\Controllers\Segment\Admin\Dictionary\Bank\JobGroup;

use App\Http\Controllers\Controller;
use App\Models\Mykj\LJurusan;
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
                return strtoupper($data->dictBankJobgroupSetJurusan->jurusan);
            })
            ->addColumn('title_eng', function($data){
                return strtoupper($data->title_eng);
            })
            ->addColumn('title_mal', function($data){
                return strtoupper($data->title_mal);
            })
            ->addColumn('active', function($data){
                return strtoupper($data->name);
            })

            ->rawColumns(['active', 'action'])
            ->make(true);
    }

    public function job_group_insert_update_page($penilaian_id){
        $jurusan = LJurusan::all();
        $grade_categories = DictBankGradeCategory::where('dict_bank_sets_id', $penilaian_id)->where('flag', 1)->where('delete_id', 0)->get();

        return view('segment.admin.dictionarybank.jobgroup.insertupdate', [
            'penilaian_id' => $penilaian_id,
            'jurusan' => $jurusan,
            'grade_categories' => $grade_categories
        ]);
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
        $process = $model->rekodActivate($request->input('grade_id'));

        return response()->json($process);
    }

    public function job_group_delete(Request $request){
        $grade_id = $request->input('grade_id');
        $model = DictBankJobgroupSet::find($grade_id);
        $model->delete_id = 1;
        if($model->save()){
            return response()->json([
                'success' => 1
            ]);
        }
    }
}
