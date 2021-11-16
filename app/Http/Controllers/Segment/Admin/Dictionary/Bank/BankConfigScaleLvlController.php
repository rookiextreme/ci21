<?php
namespace App\Http\Controllers\Segment\Admin\Dictionary\Bank;

use App\Http\Controllers\Controller;
use App\Models\Penilaian\Setting\Scalelvl\DictBankScaleLvl;
use App\Models\Penilaian\Setting\Scalelvl\DictBankScaleLvlsSet;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BankConfigScaleLvlController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function scale_level_list($penilaian_id){
        $model = DictBankScaleLvl::where('delete_id', 0)->where('dict_bank_sets_id', $penilaian_id)->get();

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
        $model = new DictBankScaleLvl;
        $process = $model->createAndUpdate($request);
        return response()->json($process);
    }

    public function scale_level_get_record(Request $request){
        $process = DictBankScaleLvl::getRecord($request->input('scale_level_id'));

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
        $model = new DictBankScaleLvl;
        $process = $model->rekodActivate($request->input('scale_level_id'));

        return response()->json($process);
    }

    public function scale_level_delete(Request $request){
        $scale_level_id = $request->input('scale_level_id');
        $model = DictBankScaleLvl::find($scale_level_id);
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

        $model = DictBankScaleLvlsSet::where('delete_id', 0)->where('dict_bank_scale_lvls_id', $scale_lvl_id)->get();

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
                return strtoupper($data->dictBankScaleLvlSetSkill->name);
            })
            ->addColumn('active', function($data){
                return strtoupper($data->name);
            })

            ->rawColumns(['active', 'action'])
            ->make(true);
    }

    public function scale_level_set_tambah(Request $request){
        $model = new DictBankScaleLvlsSet();
//        echo '<pre>';
//        print_r($request->all());
//        echo '</pre>';
//        die();
        $process = $model->createAndUpdate($request);
        return response()->json($process);
    }

    public function scale_level_set_get_record(Request $request){
        $process = DictBankScaleLvlsSet::getRecord($request->input('scale_level_set_id'));

        $data = [];
        if($process){
            $data = [
                'success' => 1,
                'data' => [
                    'name' => $process->name,
                    'skillset' => $process->dict_bank_scale_lvls_skillsets_id
                ]
            ];
        }
        return response()->json($data);
    }

    public function scale_level_set_activate(Request $request){
        $model = new DictBankScaleLvlsSet;
        $process = $model->rekodActivate($request->input('scale_level_set_id'));

        return response()->json($process);
    }

    public function scale_level_set_delete(Request $request){
        $scale_level_id = $request->input('scale_level_set_id');
        $model = DictBankScaleLvlsSet::find($scale_level_id);
        $model->delete_id = 1;
        if($model->save()){
            return response()->json([
                'success' => 1
            ]);
        }
    }
    //End Scale Level Set
}
