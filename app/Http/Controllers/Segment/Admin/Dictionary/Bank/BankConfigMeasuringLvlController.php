<?php
namespace App\Http\Controllers\Segment\Admin\Dictionary\Bank;

use App\Http\Controllers\Controller;
use App\Models\Penilaian\Setting\MeasuringLvl\DictBankMeasuringlvl;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BankConfigMeasuringLvlController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function measuring_lvl_list($penilaian_id){
        $model = DictBankMeasuringlvl::where('delete_id', 0)->where('dict_bank_sets_id', $penilaian_id)->get();

        return DataTables::of($model)
            ->setRowAttr([
                'data-measuring-lvl-id' => function($data) {
                    return $data->id;
                },
                'data-measuring-lvl-flag-id' => function($data) {
                    return $data->flag;
                },
            ])
            ->addColumn('name', function($data){
                return strtoupper($data->name);
            })
            ->addColumn('active', function($data){
                return strtoupper($data->name);
            })

            ->rawColumns(['active', 'action'])
            ->make(true);
    }

    public function measuring_lvl_tambah(Request $request){
        $model = new DictBankMeasuringlvl;
        $process = $model->createAndUpdate($request);
        return response()->json($process);
    }

    public function measuring_lvl_get_record(Request $request){
        $process = DictBankMeasuringlvl::getRecord($request->input('measuring_lvl_id'));

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

    public function measuring_lvl_activate(Request $request){
        $model = new DictBankMeasuringlvl;
        $process = $model->rekodActivate($request->input('measuring_lvl_id'));

        return response()->json($process);
    }

    public function measuring_lvl_delete(Request $request){
        $measuring_lvl_id = $request->input('measuring_lvl_id');
        $model = DictBankMeasuringlvl::find($measuring_lvl_id);
        $model->delete_id = 1;
        if($model->save()){
            return response()->json([
                'success' => 1
            ]);
        }
    }
}
