<?php
namespace App\Http\Controllers\Segment\Admin\Dictionary\Bank;

use App\Http\Controllers\Controller;
use App\Models\Penilaian\Grade\DictBankGradeCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BankConfigGradeCategoryController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function grade_category_list($penilaian_id){
        $model = DictBankGradeCategory::where('delete_id', 0)->where('dict_bank_sets_id', $penilaian_id)->get();

        return DataTables::of($model)
            ->setRowAttr([
                'data-grade-category-id' => function($data) {
                    return $data->id;
                },
                'data-grade-category-flag-id' => function($data) {
                    return $data->flag;
                },
            ])
            ->addColumn('name', function($data){
                return strtoupper($data->name);
            })
            ->addColumn('jumlah_gred', function($data){
                return $data->dictBankGradeCategoryGetGrade ? count($data->dictBankGradeCategoryGetGrade) : 0;
            })
            ->addColumn('active', function($data){
                return strtoupper($data->name);
            })

            ->rawColumns(['active', 'action'])
            ->make(true);
    }

    public function grade_category_tambah(Request $request){
        $model = new DictBankGradeCategory;
        $process = $model->createAndUpdate($request);
        return response()->json($process);
    }

    public function grade_category_get_record(Request $request){
        $process = DictBankGradeCategory::getRecord($request->input('grade_category_id'));

        $grade_listing = [];
        foreach($process->dictBankGradeCategoryGetGrade as $gL){
            $grade_listing[] = $gL->grades_id;
        }

        $data = [];
        if($process){
            $data = [
                'success' => 1,
                'data' => [
                    'name' => $process->name,
                    'grade_list' => $grade_listing
                ]
            ];
        }
        return response()->json($data);
    }

    public function grade_category_activate(Request $request){
        $model = new DictBankGradeCategory;
        $process = $model->rekodActivate($request->input('grade_category_id'));

        return response()->json($process);
    }

    public function grade_category_delete(Request $request){
        $grade_id = $request->input('grade_category_id');
        $model = DictBankGradeCategory::find($grade_id);
        $model->delete_id = 1;
        if($model->save()){
            return response()->json([
                'success' => 1
            ]);
        }
    }
}
