<?php
namespace App\Http\Controllers\Segment\Admin\Dictionary\Collection;

use App\Http\Controllers\Controller;
use App\Models\Collection\DictCol\Question\DictColSetsCompetenciesQuestion;
use App\Models\Collection\DictCol\Set\DictColSetsItem;
use App\Models\Collection\Grade\DictColGradeCategory;
use App\Models\Collection\Setting\Measuringlvl\DictColMeasuringlvl;
use App\Models\Collection\Setting\Scalelvl\DictColCompetencyTypesScaleLvl;
use App\Models\Collection\Setting\Scalelvl\DictColScaleLvl;
use App\Models\Mykj\LJurusan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ColQuesController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //Dictionary Question
    public function dict_ques_list(Request $request){
        $item_id = $request->input('item_id');
        $model = DictColSetsCompetenciesQuestion::where('delete_id', 0)->where('dict_col_sets_items_id', $item_id)->get();

        return DataTables::of($model)
            ->setRowAttr([
                'data-dict-col-ques-id' => function($data) {
                    return $data->id;
                },
                'data-dict-col-ques-flag-id' => function($data) {
                    return $data->flag;
                },
            ])
            ->addColumn('name', function($data){
                return strtoupper($data->title_eng);
            })
            ->addColumn('nameMal', function($data){
                return $data->title_mal ? strtoupper($data->title_mal) : 'Tiada Versi Melayu';
            })
            ->addColumn('active', function($data){
                return strtoupper($data->name);
            })
            ->rawColumns(['active', 'action'])
            ->make(true);
    }

    public function dict_ques_tambah(Request $request){
        $model = new DictColSetsCompetenciesQuestion;
        $process = $model->createAndUpdate($request);
        return response()->json($process);
    }

    public function dict_ques_get_record(Request $request){
        $process = DictColSetsCompetenciesQuestion::getRecord($request->input('dict_col_ques_id'));

        $data = [];
        if($process){
            $data = [
                'success' => 1,
                'data' => [
                    'name_eng' => $process->title_eng,
                    'name_mal' => $process->title_mal,
                ]
            ];
        }
        return response()->json($data);
    }

    public function dict_ques_activate(Request $request){
        $model = new DictColSetsCompetenciesQuestion;
        $process = $model->rekodActivate($request->input('dict_col_ques_id'));

        return response()->json($process);
    }

    public function dict_ques_delete(Request $request){
        $dict_col_ques_id = $request->input('dict_col_ques_id');
        $model = DictColSetsCompetenciesQuestion::find($dict_col_ques_id);
        $model->delete_id = 1;
        if($model->save()){
            return response()->json([
                'success' => 1
            ]);
        }
    }
    //End Main Dictionary
}
