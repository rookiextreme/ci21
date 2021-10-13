<?php

namespace App\Http\Controllers\Segment\Admin\Dictionary\Bank;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penilaian\DictBank\Set\DictBankSet;
use App\Models\Collection\Setting\Competency\DictColCompetencyType;
use App\Models\Collection\Setting\Measuringlvl\DictColMeasuringlvl;
use DataTables;

class BankController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request) {
        date_default_timezone_set('Asia/Kuala_Lumpur');

        $current_year = intval(date("Y"));

        $col_years = array();

        for ($i=0; $i < 11; $i++) { 
            $col_years[] = $current_year;
            $current_year += 1;
        }

        $competency_types = DictColCompetencyType::where('flag',1)->get();
        $measuring_levels = DictColMeasuringlvl::where('flag',1)->get();

        return view('segment.admin.dictionary.bank.index',[
            'years' => $col_years,
            'competency_types' => $competency_types,
            'measuring_levels' => $measuring_levels
        ]);
    }

    public function dict_bank_datalist(Request $request) {
        $model = DictBankSet::all();

        return DataTables::of($model)
            ->setRowAttr([
                'data-dict-bank-id' => function($data) {
                    return $data->id;
                },
                'data-dict-bank-flag-id' => function($data) {
                    return $data->flag;
                },
            ])
            ->rawColumns(['action'])
            ->make(true);
    }
}
