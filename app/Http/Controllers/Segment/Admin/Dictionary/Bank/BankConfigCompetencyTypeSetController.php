<?php
namespace App\Http\Controllers\Segment\Admin\Dictionary\Bank;

use App\Http\Controllers\Controller;
use App\Models\Penilaian\Setting\Scalelvl\DictBankCompetencyTypesScaleLvl;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BankConfigCompetencyTypeSetController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function competency_type_set_list($penilaian_id){
        $model = DictBankCompetencyTypesScaleLvl::where('delete_id', 0)->where('dict_bank_sets_id', $penilaian_id)->get();

        return DataTables::of($model)
            ->setRowAttr([
                'data-competency-type-set-id' => function($data) {
                    return $data->id;
                },
                'data-competency-type-set-flag-id' => function($data) {
                    return $data->flag;
                },
            ])
            ->addColumn('competency', function($data){
                return strtoupper($data->dictbankCompetencyTypeScaleBridgeCompetency->name);
            })
            ->addColumn('scale_level', function($data){
                return strtoupper($data->dictbankCompetencyTypeScaleBridgeScale->name);
            })
            ->addColumn('active', function($data){
                return strtoupper($data->name);
            })

            ->rawColumns(['active', 'action'])
            ->make(true);
    }

    public function competency_type_set_tambah(Request $request){
        $model = new DictBankCompetencyTypesScaleLvl();
        $process = $model->createAndUpdate($request);
        return response()->json($process);
    }

    public function competency_type_set_get_record(Request $request){
        $process = DictBankCompetencyTypesScaleLvl::getRecord($request->input('competency_type_set_id'));

        $data = [];
        if($process){
            $data = [
                'success' => 1,
                'data' => [
                    'com_type' => $process->dict_bank_competency_types_id,
                    'scale_level' => $process->dict_bank_scale_lvls_id
                ]
            ];
        }
        return response()->json($data);
    }

    public function competency_type_set_activate(Request $request){
        $model = new DictBankCompetencyTypesScaleLvl;
        $process = $model->rekodActivate($request->input('competency_type_set_id'));

        return response()->json($process);
    }

    public function competency_type_set_delete(Request $request){
        $competency_type_set_id = $request->input('competency_type_set_id');
        $model = DictBankCompetencyTypesScaleLvl::find($competency_type_set_id);
        $model->delete_id = 1;
        if($model->save()){
            return response()->json([
                'success' => 1
            ]);
        }
    }
}
