<?php
namespace App\Http\Controllers\Segment\Admin\Dictionary\Bank;

use App\Http\Controllers\Controller;
use App\Models\Penilaian\DictBank\Set\DictBankSet;
use App\Models\Regular\Year;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use DateTime;

class BankController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $tahun = Year::where('year', '<=', date('Y'))->get();
        return view('segment.admin.dictionarybank.penilaian.index', [
            'year' => $tahun
        ]);
    }

    public function penilaian_list(){
        $model = DictBankSet::where('delete_id', 0)->get();

        return DataTables::of($model)
            ->setRowAttr([
                'data-bank-set-id' => function($data) {
                    return $data->id;
                },
                'data-bank-set-flag-id' => function($data) {
                    return $data->flag;
                },
            ])
            ->addColumn('name', function($data){
                return strtoupper($data->title);
            })
            ->addColumn('tkh_mula', function($data){
                return strtoupper($data->tkh_mula);
            })
            ->addColumn('tkh_tamat', function($data){
                return strtoupper($data->tkh_tamat);
            })
            ->addColumn('publish', function($data){
                if($data->flag_publish == 1) {
                    $now = new DateTime('NOW');
                    $start = new DateTime($data->tkh_mula);
                    $end = new DateTime($data->tkh_tamat);
                    if($now->getTimestamp() > $start->getTimestamp() && $now->getTimestamp() < $end->getTimestamp()) {
                        return strtoupper('AKTIF');
                    } else if($now->getTimestamp() > $end->getTimestamp()){
                        return strtoupper('TUTUP');
                    } else {
                        return strtoupper('TERBIT');
                    }
                } else {
                    return strtoupper($data->flag_publish == 0 ? 'Draf' : 'Dihantar');
                }
            })
            ->addColumn('active', function($data){
                return strtoupper($data->flag);
            })

            ->rawColumns(['active', 'action'])
            ->make(true);
    }

    public function penilaian_tambah(Request $request){
        $model = new DictBankSet();
        $process = $model->createAndUpdate($request);
        return response()->json($process);
    }

    public function penilaian_get_record(Request $request){
        $process = DictBankSet::getRecord($request->input('penilaian_id'));

        $data = [];
        if($process){
            $data = [
                'success' => 1,
                'data' => [
                    'name' => $process->title,
                    'tahun' => $process->years_id,
                    'tkh_mula' => $process->tkh_mula,
                    'tkh_tamat' => $process->tkh_tamat
                ]
            ];
        }
        return response()->json($data);
    }

    public function penilaian_activate(Request $request){
        $model = new DictBankSet;
        $process = $model->rekodActivate($request->input('penilaian_id'));

        return response()->json($process);
    }

    public function penilaian_delete(Request $request){
        $grade_id = $request->input('penilaian_id');
        $model = DictBankSet::find($grade_id);
        $model->delete_id = 1;
        if($model->save()){
            return response()->json([
                'success' => 1
            ]);
        }
    }

    public function publish_penilaian(Request $request)
    {
        $grade_id = $request->input('penilaian_id');
        $model = DictBankSet::find($grade_id);
        $model->flag_publish = $model->flag_publish == 1 ? 0 : 1;
        if($model->save()){
            return response()->json([
                'success' => 1
            ]);
        }
    }
}
