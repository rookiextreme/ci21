<?php
namespace App\Http\Controllers\Segment\Admin\Dictionary\Collection;

use App\Http\Controllers\Controller;
use App\Models\Collection\DictCol\Question\DictColSetsCompetenciesQuestion;
use App\Models\Collection\DictCol\Set\DictColSetsItem;
use App\Models\Collection\Grade\DictColGradeCategory;
use App\Models\Collection\Setting\MeasuringLvl\DictColMeasuringlvl;
use App\Models\Collection\Setting\Scalelvl\DictColCompetencyTypesScaleLvl;
use App\Models\Collection\Setting\Scalelvl\DictColScaleLvl;
use App\Models\Mykj\LJurusan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ColController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //Main Dictionary
    public function index(){
        $measuring_level = DictColMeasuringlvl::where('flag', 1)->where('delete_id', 0)->get();
        $jurusan = LJurusan::all();
        $competency_type = DictColCompetencyTypesScaleLvl::where('flag', 1)->where('delete_id', 0)->get();
        $gradeCategory = DictColGradeCategory::where('flag', 1)->where('delete_id', 0)->get();

        return view('segment.admin.dictionary.collection.index', [
            'measuring_level' => $measuring_level,
            'jurusan' => $jurusan,
            'competency_type' => $competency_type,
            'grade_category' => $gradeCategory,
        ]);
    }

    public function dict_list(){
        $model = DictColSetsItem::where('delete_id', 0)->get();

        return DataTables::of($model)
            ->setRowAttr([
                'data-dict-col-id' => function($data) {
                    return $data->id;
                },
                'data-dict-col-flag-id' => function($data) {
                    return $data->flag;
                },
            ])
            ->addColumn('name', function($data){
                return strtoupper($data->title_eng);
            })
            ->addColumn('measure', function($data){
                return strtoupper($data->dictColSetsItemMeasuringLvl->name);
            })
            ->addColumn('com_type', function($data){
                return strtoupper($data->dictColSetsItemCompetencyTypeScaleLvl->dictColCompetencyTypeScaleBridgeCompetency->name);
            })
            ->addColumn('jurusan', function($data){
                return strtoupper($data->dictColSetsItemJurusan ? $data->dictColSetsItemJurusan->jurusan : 'Tiada Jurusan');
            })
            ->addColumn('grade_category', function($data){
                return strtoupper($data->dictColSetsItemDictGradeCategory->name);
            })
            ->addColumn('active', function($data){
                return strtoupper($data->name);
            })
            ->rawColumns(['active', 'action'])
            ->make(true);
    }

    public function dict_tambah(Request $request){
        $model = new DictColSetsItem;
        $process = $model->createAndUpdate($request);
        return response()->json($process);
    }

    public function dict_get_record(Request $request){
        $process = DictColSetsItem::getRecord($request->input('dict_col_id'));

        $data = [];
        if($process){
            $data = [
                'success' => 1,
                'data' => [
                    'name_eng' => $process->title_eng,
                    'name_mal' => $process->title_mal,
                    'measuring_level' => $process->dict_col_measuring_lvls_id,
                    'competency_type' => $process->dict_col_competency_types_scale_lvls_id,
                    'jurusan' => $process->jurusan_id,
                    'grade_category' => $process->dict_col_grades_categories_id
                ]
            ];
        }
        return response()->json($data);
    }

    public function dict_activate(Request $request){
        $model = new DictColSetsItem;
        $process = $model->rekodActivate($request->input('dict_col_id'));

        return response()->json($process);
    }

    public function dict_delete(Request $request){
        $dict_col_id = $request->input('dict_col_id');
        $model = DictColSetsItem::find($dict_col_id);
        $model->delete_id = 1;
        if($model->save()){
            return response()->json([
                'success' => 1
            ]);
        }
    }
    //End Main Dictionary
}
