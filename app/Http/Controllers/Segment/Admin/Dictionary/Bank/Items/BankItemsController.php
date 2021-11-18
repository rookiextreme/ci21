<?php
namespace App\Http\Controllers\Segment\Admin\Dictionary\Bank\Items;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penilaian\Grade\DictBankGradeCategory;
use App\Models\Penilaian\Setting\Scalelvl\DictBankCompetencyTypesScaleLvl;
use App\Models\Penilaian\Setting\Measuringlvl\DictBankMeasuringlvl;
use App\Models\Penilaian\DictBank\Set\DictBankSetsItem;
use App\Models\Mykj\LJurusan;
use Yajra\DataTables\DataTables;

class BankItemsController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($penilaian_id){
        $measuring_level = DictBankMeasuringlvl::where('flag', 1)->where('delete_id', 0)->where('dict_bank_sets_id',$penilaian_id)->get();
        $jurusan = LJurusan::all();

        $competency_type = DictBankCompetencyTypesScaleLvl::where('flag', 1)->where('delete_id', 0)->where('dict_bank_sets_id',$penilaian_id)->get();
        $gradeCategory = DictBankGradeCategory::where('flag', 1)->where('delete_id', 0)->where('dict_bank_sets_id',$penilaian_id)->get();

        return view('segment.admin.dictionarybank.penilainitem.index', [
            'measuring_level' => $measuring_level,
            'jurusan' => $jurusan,
            'competency_type' => $competency_type,
            'grade_category' => $gradeCategory,
            'penilaian_id' => $penilaian_id
        ]);
    }

    public function bank_item_list($penilaian_id){
        $model = DictBankSetsItem::where('delete_id', 0)->where('dict_bank_sets_id',$penilaian_id)->get();

        return DataTables::of($model)
            ->setRowAttr([
                'data-bank-col-id' => function($data) {
                    return $data->id;
                },
                'data-bank-col-flag-id' => function($data) {
                    return $data->flag;
                },
            ])
            ->addColumn('name', function($data){
                return strtoupper($data->title_eng);
            })
            ->addColumn('measure', function($data){
                return strtoupper($data->dictBankSetsItemMeasuringLvl->name);
            })
            ->addColumn('com_type', function($data){
                return strtoupper($data->dictBankSetsItemCompetencyTypeScaleLvl->dictBankCompetencyTypeScaleBridgeCompetency->name);
            })
            ->addColumn('jurusan', function($data){
                return strtoupper($data->dictBankSetsItemJurusan ? $data->dictBankSetsItemJurusan->jurusan : 'Tiada Jurusan');
            })
            ->addColumn('grade_category', function($data){
                return strtoupper($data->dictBankSetsItemDictGradeCategory->name);
            })
            ->addColumn('active', function($data){
                return strtoupper($data->flag);
            })
            ->rawColumns(['active', 'action'])
            ->make(true);
    }

    public function bank_item_save(Request $request){
        $model = new DictBankSetsItem;
        $process = $model->createAndUpdate($request);
        return response()->json($process);
    }

    public function bank_item_get_record(Request $request){
        $process = DictBankSetsItem::getRecord($request->input('dict_col_id'));

        $data = [];
        if($process){
            $data = [
                'success' => 1,
                'data' => [
                    'title_eng' => $process->title_eng,
                    'title_mal' => $process->title_mal,
                    'jurusan' => $process->jurusan_id,
                    'measuring_lvl' => $process->dict_bank_measuring_lvls_id,
                    'grade_category' => $process->dict_bank_grades_categories_id,

                ]
            ];
        }
        return response()->json($data);
    }

    public function bank_col_activate(Request $request){
        $model = new DictBankSetsItem;
        $process = $model->rekodActivate($request->input('dict_col_id'));

        return response()->json($process);
    }

    public function bank_col_delete(Request $request){
        $dict_col_id = $request->input('dict_col_id');
        $model = DictBankSetsItem::find($dict_col_id);
        $model->delete_id = 1;
        if($model->save()){
            return response()->json([
                'success' => 1
            ]);
        }
    }
}
