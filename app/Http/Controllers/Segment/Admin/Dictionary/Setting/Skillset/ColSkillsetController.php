<?php
namespace App\Http\Controllers\Segment\Admin\Dictionary\Setting\Skillset;

use App\Http\Controllers\Controller;
use App\Models\Collection\Setting\Scalelvl\DictColScaleLvlsSkillset;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ColSkillsetController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        return view('segment.admin.dictionary.setting.skillset.index');
    }

    public function skill_set_list(){
        $model = DictColScaleLvlsSkillset::where('delete_id', 0)->get();

        return DataTables::of($model)
            ->setRowAttr([
                'data-scale-skill-set-id' => function($data) {
                    return $data->id;
                },
                'data-scale-skill-set-flag-id' => function($data) {
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

    public function skill_set_tambah(Request $request){
        $model = new DictColScaleLvlsSkillset;
        $process = $model->createAndUpdate($request);
        return response()->json($process);
    }

    public function skill_set_get_record(Request $request){
        $process = DictColScaleLvlsSkillset::getRecord($request->input('scale_skill_set_id'));

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

    public function skill_set_activate(Request $request){
        $model = new DictColScaleLvlsSkillset;
        $process = $model->rekodActivate($request->input('scale_skill_set_id'));

        return response()->json($process);
    }

    public function skill_set_delete(Request $request){
        $scale_skill_set_id = $request->input('scale_skill_set_id');
        $model = DictColScaleLvlsSkillset::find($scale_skill_set_id);
        $model->delete_id = 1;
        if($model->save()){
            return response()->json([
                'success' => 1
            ]);
        }
    }
}
