<?php
namespace App\Http\Controllers\Segment\Admin\Dictionary\Bank\JobGroup\Score;

use App\Http\Controllers\Controller;
use App\Models\Penilaian\Jobgroup\Score\DictBankJobgroupSetsItemsScoresSetsGrade;
use App\Models\Penilaian\Jobgroup\Set\DictBankJobgroupSet;
use Illuminate\Http\Request;

class BankJobGroupScoreController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($job_group_id){

        $job_group = DictBankJobgroupSet::find($job_group_id);

        //creating or updating the scoreset
        DictBankJobgroupSetsItemsScoresSetsGrade::createUpdateItemScoreList($job_group);
//        die();
        //end creating or updating the scoreset
        $getScoreSet = DictBankJobgroupSetsItemsScoresSetsGrade::getLatestScoreSet($job_group);

        return view('segment.admin.dictionarybank.jobgroup.scoresetting', [
            'data' => $getScoreSet,
            'job_group_id' => $job_group_id,
            'penilaian_id' => $job_group->dict_bank_sets_id
        ]);
    }

    public function job_group_score_tambah(Request $request){
        $process = DictBankJobgroupSetsItemsScoresSetsGrade::updateAllScore($request);
        return response()->json([
            'success' => 1
        ]);
    }
}
