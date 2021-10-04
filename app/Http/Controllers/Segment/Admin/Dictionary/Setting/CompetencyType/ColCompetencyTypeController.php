<?php
namespace App\Http\Controllers\Segment\Admin\Dictionary\Setting\CompetencyType;

use App\Http\Controllers\Controller;
use App\Models\Collection\Setting\Competency\DictColCompetencyType;
use App\Models\Collection\Setting\Scalelvl\DictColScaleLvl;
use App\Models\Penilaian\Setting\Scalelvl\DictBankScaleLvl;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ColCompetencyTypeController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('segment.admin.dictionary.setting.competencytype.index');
    }

    public function competency_type_list(){
        $model = DictColCompetencyType::where('delete_id', 0)->get();

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
        $model = new DictColCompetencyType;
        $process = $model->createAndUpdate($request);
        return response()->json($process);
    }

    public function competency_type_get_record(Request $request){
        $process = DictColCompetencyType::getRecord($request->input('competency_type_id'));

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

    public function competency_type_activate(Request $request){
        $model = new DictColCompetencyType;
        $process = $model->rekodActivate($request->input('competency_type_id'));

        return response()->json($process);
    }

    public function competency_type_delete(Request $request){
        $competency_type_id = $request->input('competency_type_id');
        $model = DictColCompetencyType::find($competency_type_id);
        $model->delete_id = 1;
        if($model->save()){
            return response()->json([
                'success' => 1
            ]);
        }
    }
}
