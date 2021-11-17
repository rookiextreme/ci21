<?php
namespace App\Http\Controllers\Segment\Admin\Dictionary\Bank\JobGroup\Score;

use App\Http\Controllers\Controller;
use App\Models\Penilaian\Jobgroup\Score\DictBankSetsItemsScoresSetsGrade;
use App\Models\Penilaian\Jobgroup\Set\DictBankJobgroupSet;

class BankJobGroupScoreController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($job_group_id){
        $job_group = DictBankJobgroupSet::find($job_group_id);
        //creating or updating the scoreset
        DictBankSetsItemsScoresSetsGrade::createUpdateItemScoreList($job_group);
        //end creating or updating the scoreset
        $getScoreSet = DictBankSetsItemsScoresSetsGrade::getLatestScoreSet($job_group);

        return view('segment.admin.dictionarybank.jobgroup.scoresetting', [
            'data' => $getScoreSet,
            'job_group_id' => $job_group_id
        ]);
    }
}
