<?php
namespace App\Http\Controllers\Segment\Admin\Dictionary\MeasuringLvl;

use App\Http\Controllers\Controller;
use App\Models\Collection\Setting\MeasuringLvl\DictColMeasuringlvl;
use http\Env\Response;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ColMeasuringLvlController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('segment.admin.dictionary.measuringlvl.index');
    }

    public function measuring_lvl_list(){
        $model = DictColMeasuringlvl::where('delete_id', 0)->get();

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
        $model = new DictColMeasuringlvl;
        $process = $model->createAndUpdate($request);
        return response()->json($process);
    }

    public function measuring_lvl_get_record(Request $request){
        $process = DictColMeasuringlvl::getRecord($request->input('measuring_lvl_id'));

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
        $model = new DictColMeasuringlvl;
        $process = $model->rekodActivate($request->input('measuring_lvl_id'));

        return response()->json($process);
    }

    public function measuring_lvl_delete(Request $request){
        $measuring_lvl_id = $request->input('measuring_lvl_id');
        $model = DictColMeasuringlvl::find($measuring_lvl_id);
        $model->delete_id = 1;
        if($model->save()){
            return response()->json([
                'success' => 1
            ]);
        }
    }
}
