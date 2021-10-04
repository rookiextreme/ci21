<?php
namespace App\Http\Controllers\Segment\Admin\Dictionary\ScaleLvl;

use App\Http\Controllers\Controller;
use App\Models\Collection\Setting\Scalelvl\DictColScaleLvl;
use App\Models\Collection\Setting\Scalelvl\DictColScaleLvlsSet;
use App\Models\Collection\Setting\Scalelvl\DictColScaleLvlsSkillset;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ColScaleLvlController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //Scale Level
    public function index(){
        $skill_set = DictColScaleLvlsSkillset::where('flag', 1)->where('delete_id', 0)->get();

        return view('segment.admin.dictionary.scalelvl.index',[
            'skillSet' => $skill_set,
        ]);
    }

    public function scale_level_list(){
        $model = DictColScaleLvl::where('delete_id', 0)->get();

        return DataTables::of($model)
            ->setRowAttr([
                'data-scale-level-id' => function($data) {
                    return $data->id;
                },
                'data-scale-level-flag-id' => function($data) {
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

    public function scale_level_tambah(Request $request){
        $model = new DictColScaleLvl;
        $process = $model->createAndUpdate($request);
        return response()->json($process);
    }

    public function scale_level_get_record(Request $request){
        $process = DictColScaleLvl::getRecord($request->input('scale_level_id'));

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

    public function scale_level_activate(Request $request){
        $model = new DictColScaleLvl;
        $process = $model->rekodActivate($request->input('scale_level_id'));

        return response()->json($process);
    }

    public function scale_level_delete(Request $request){
        $scale_level_id = $request->input('scale_level_id');
        $model = DictColScaleLvl::find($scale_level_id);
        $model->delete_id = 1;
        if($model->save()){
            return response()->json([
                'success' => 1
            ]);
        }
    }
    //End Scale Level

    //Scale Level Set
    public function scale_level_set_list(Request $request){
        $scale_lvl_id = $request->input('scale_lvl_id');

        $model = DictColScaleLvlsSet::where('delete_id', 0)->where('dict_col_scale_lvls_id', $scale_lvl_id)->get();

        return DataTables::of($model)
            ->setRowAttr([
                'data-scale-level-set-id' => function($data) {
                    return $data->id;
                },
                'data-scale-level-set-flag-id' => function($data) {
                    return $data->flag;
                },
            ])
            ->addColumn('name', function($data){
                return strtoupper($data->name);
            })
            ->addColumn('skillset', function($data){
                return strtoupper($data->dictColScaleLvlSetSkill->name);
            })
            ->addColumn('active', function($data){
                return strtoupper($data->name);
            })

            ->rawColumns(['active', 'action'])
            ->make(true);
    }

    public function scale_level_set_tambah(Request $request){
        $model = new DictColScaleLvlsSet();
        $process = $model->createAndUpdate($request);
        return response()->json($process);
    }

    public function scale_level_set_get_record(Request $request){
        $process = DictColScaleLvlsSet::getRecord($request->input('scale_level_set_id'));

        $data = [];
        if($process){
            $data = [
                'success' => 1,
                'data' => [
                    'name' => $process->name,
                    'skillset' => $process->dict_col_scale_lvls_skillsets_id
                ]
            ];
        }
        return response()->json($data);
    }

    public function scale_level_set_activate(Request $request){
        $model = new DictColScaleLvlsSet;
        $process = $model->rekodActivate($request->input('scale_level_set_id'));

        return response()->json($process);
    }

    public function scale_level_set_delete(Request $request){
        $scale_level_id = $request->input('scale_level_set_id');
        $model = DictColScaleLvlsSet::find($scale_level_id);
        $model->delete_id = 1;
        if($model->save()){
            return response()->json([
                'success' => 1
            ]);
        }
    }
    //End Scale Level Set

}
