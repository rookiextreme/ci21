<?php
namespace App\Http\Controllers\Segment\Admin\Dictionary\Bank;

use App\Http\Controllers\Controller;
use App\Models\Penilaian\Setting\Competency\DictBankCompetencyType;
use App\Models\Penilaian\Setting\Scalelvl\DictBankCompetencyTypesScaleLvl;
use App\Models\Penilaian\Setting\Scalelvl\DictBankScaleLvl;
use App\Models\Penilaian\Setting\Scalelvl\DictBankScaleLvlsSkillset;
use App\Models\Regular\Grade;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BankConfigController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($penilaian_id){
        $scale_level = DictBankScaleLvl::where('flag', 1)->where('delete_id', 0)->where('dict_bank_sets_id', $penilaian_id)->get();
        $competency_type = DictBankCompetencyType::where('flag', 1)->where('delete_id', 0)->where('dict_bank_sets_id', $penilaian_id)->get();
        $grade = Grade::where('delete_id', 0)->where('flag', 1)->get();
        $skill_set = DictBankScaleLvlsSkillset::where('flag', 1)->where('delete_id', 0)->get();

        return view('segment.admin.dictionarybank.penilaianconfig.index', [
            'scale_level' => $scale_level,
            'competency_type' => $competency_type,
            'grades' => $grade,
            'penilaian_id' => $penilaian_id,
            'skillSet' => $skill_set,
        ]);
    }

}
