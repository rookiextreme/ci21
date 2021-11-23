<?php
namespace App\Http\Controllers\Segment\Admin\Dictionary\Bank;

use App\Http\Controllers\Controller;
use App\Models\Penilaian\Setting\Competency\DictBankCompetencyType;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BankConfigCompetencyTypeController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function competency_type_list($penilaian_id){
        $model = DictBankCompetencyType::where('delete_id', 0)->where('dict_bank_sets_id', $penilaian_id)->get();

        return DataTables::of($model)
            ->setRowAttr([
                'data-competency-type-id' => function($data) {
                    return $data->id;
                },
                'data-competency-type-flag-id' => function($data) {
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

    public function competency_type_tambah(Request $request){
        $model = new DictBankCompetencyType;
        $process = $model->createAndUpdate($request);
        return response()->json($process);
    }

    public function competency_type_get_record(Request $request){
        $process = DictBankCompetencyType::getRecord($request->input('competency_type_id'));

        $data = [];
        if($process){
            $data = [
                'success' => 1,
                'data' => [
                    'name' => $process->name,
                    'tech' => $process->tech_discipline_flag
                ]
            ];
        }
        return response()->json($data);
    }

    public function competency_type_activate(Request $request){
        $model = new DictBankCompetencyType;
        $process = $model->rekodActivate($request->input('competency_type_id'));

        return response()->json($process);
    }

    public function competency_type_delete(Request $request){
        $competency_type_id = $request->input('competency_type_id');
        $model = DictBankCompetencyType::find($competency_type_id);
        $model->delete_id = 1;
        if($model->save()){
            return response()->json([
                'success' => 1
            ]);
        }
    }
}
