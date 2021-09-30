<?php
namespace App\Http\Controllers\Segment\Admin\Setting\Grade;

use App\Http\Controllers\Controller;
use App\Models\Regular\Grade;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class GradeController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        return view('segment.admin.setting.grade.index');
    }

    public function grade_list(){
        $model = Grade::where('delete_id', 0)->get();

        return DataTables::of($model)
            ->setRowAttr([
                'data-grade-id' => function($data) {
                    return $data->id;
                },
                'data-grade-flag-id' => function($data) {
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

    public function grade_tambah(Request $request){
        $model = new Grade;
        $process = $model->createAndUpdate($request);
        return response()->json($process);
    }

    public function grade_get_record(Request $request){
        $process = Grade::getRecord($request->input('grade_id'));

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

    public function grade_activate(Request $request){
        $model = new Grade;
        $process = $model->rekodActivate($request->input('grade_id'));

        return response()->json($process);
    }

    public function grade_delete(Request $request){
        $grade_id = $request->input('grade_id');
        $model = Grade::find($grade_id);
        $model->delete_id = 1;
        if($model->save()){
            return response()->json([
                'success' => 1
            ]);
        }
    }
}
