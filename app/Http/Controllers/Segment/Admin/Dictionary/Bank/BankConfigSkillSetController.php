<?php
namespace App\Http\Controllers\Segment\Admin\Dictionary\Bank;

use App\Http\Controllers\Controller;
use App\Models\Penilaian\Setting\Scalelvl\DictBankScaleLvlsSkillset;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BankConfigSkillSetController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function skill_set_list($penilaian_id){
        $model = DictBankScaleLvlsSkillset::where('delete_id', 0)->where('dict_bank_sets_id', $penilaian_id)->get();

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
        $model = new DictBankScaleLvlsSkillset;
        $process = $model->createAndUpdate($request);
        return response()->json($process);
    }

    public function skill_set_get_record(Request $request){
        $process = DictBankScaleLvlsSkillset::getRecord($request->input('scale_skill_set_id'));

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
        $model = new DictBankScaleLvlsSkillset;
        $process = $model->rekodActivate($request->input('scale_skill_set_id'));

        return response()->json($process);
    }

    public function skill_set_delete(Request $request){
        $scale_skill_set_id = $request->input('scale_skill_set_id');
        $model = DictBankScaleLvlsSkillset::find($scale_skill_set_id);
        $model->delete_id = 1;
        if($model->save()){
            return response()->json([
                'success' => 1
            ]);
        }
    }
}
