<?php
namespace App\Http\Controllers\Segment\Admin\Dictionary\CompetencyTypeSet;

use App\Http\Controllers\Controller;
use App\Models\Collection\Setting\Competency\DictColCompetencyType;
use App\Models\Collection\Setting\Scalelvl\DictColCompetencyTypesScaleLvl;
use App\Models\Collection\Setting\Scalelvl\DictColScaleLvl;
use App\Models\Penilaian\Setting\Scalelvl\DictBankScaleLvl;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ColCompetencyTypeSetController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $scale_level = DictColScaleLvl::where('flag', 1)->where('delete_id', 0)->get();
        $competency_type = DictColCompetencyType::where('flag', 1)->where('delete_id', 0)->get();

        return view('segment.admin.dictionary.competencytypeset.index', [
            'scale_level' => $scale_level,
            'competency_type' => $competency_type
        ]);
    }

    public function competency_type_set_list(){
        $model = DictColCompetencyTypesScaleLvl::where('delete_id', 0)->get();

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
                return strtoupper($data->dictColCompetencyTypeScaleBridgeCompetency->name);
            })
            ->addColumn('scale_level', function($data){
                return strtoupper($data->dictColCompetencyTypeScaleBridgeScale->name);
            })
            ->addColumn('active', function($data){
                return strtoupper($data->name);
            })

            ->rawColumns(['active', 'action'])
            ->make(true);
    }

    public function competency_type_set_tambah(Request $request){
        $model = new DictColCompetencyTypesScaleLvl();
        $process = $model->createAndUpdate($request);
        return response()->json($process);
    }

    public function competency_type_set_get_record(Request $request){
        $process = DictColCompetencyTypesScaleLvl::getRecord($request->input('competency_type_set_id'));

        $data = [];
        if($process){
            $data = [
                'success' => 1,
                'data' => [
                    'com_type' => $process->dict_col_competency_types_id,
                    'scale_level' => $process->dict_col_scale_lvls_id
                ]
            ];
        }
        return response()->json($data);
    }

    public function competency_type_set_activate(Request $request){
        $model = new DictColCompetencyTypesScaleLvl;
        $process = $model->rekodActivate($request->input('competency_type_set_id'));

        return response()->json($process);
    }

    public function competency_type_set_delete(Request $request){
        $competency_type_set_id = $request->input('competency_type_set_id');
        $model = DictColCompetencyTypesScaleLvl::find($competency_type_set_id);
        $model->delete_id = 1;
        if($model->save()){
            return response()->json([
                'success' => 1
            ]);
        }
    }
}
