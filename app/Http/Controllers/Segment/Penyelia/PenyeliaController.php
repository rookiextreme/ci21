<?php
namespace App\Http\Controllers\Segment\Penyelia;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Segment\Pengguna\PenilaianScore\PenilaianScoreController;
use App\Models\Penilaian\Main\Penilaian;
use App\Models\Penilaian\Main\PenilaiansCompetenciesPenyeliaAvg;
use Auth;
use Illuminate\Http\Request;

class PenyeliaController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $penyelia_id = Auth::user()->user_profile->id;

        $getPenilaian = Penilaian::where('penyelia_profiles_id', $penyelia_id)->where('penyelia_update', 0)->get();

        return view('segment.penyelia.pengesahan.new.index', [
            'penilaian' => $getPenilaian
        ]);
    }

    public function pengesahan_result($profiles_id, $penilaian_id, $trigger){
        $penilaian = Penilaian::where('id', $penilaian_id)->first();

        $penilaian_class = new PenilaianScoreController;

        if($penilaian->penyelia_update == 1){
            $penilaian_keputusan = $penilaian_class->computeResult($penilaian_id, true);
        }else{
            $penilaian_keputusan = $penilaian_class->computeResult($penilaian_id);
        }


        $penilaian_user = [
            'name' => $penilaian->profile_Users->profile_Users->name,
            's_gred' => $penilaian->standard_gred,
            'a_gred' => $penilaian->actual_gred,
            'penyelia' => $penilaian->penyelia_profiles_id
        ];

        return view('segment.penyelia.pengesahan.new.keputusan', [
            'name' => $penilaian->penilaianDictBankSet->title,
            'data' => $penilaian_keputusan,
            'user' => $penilaian_user,
            'penilaian_id' => $penilaian_id,
            'penyelia_update' => $penilaian->penyelia_update,
            'trigger' => $trigger
        ]);
    }

    public function result_keputusan_with_penyelia($penilaian_id){
        $penilaian = Penilaian::where('id', $penilaian_id)->first();

        $penilaianScore = new PenilaianScoreController;
        $main_keputusan = $penilaianScore->computeResult($penilaian_id);
        $penyelia_keputusan = $penilaianScore->computeResult($penilaian_id, true);

        return view('segment.penyelia.pengesahan.new.keputusan_penyelia', [
            'name' => $penilaian->penilaianDictBankSet->title,
            'data' => $main_keputusan,
            'data_p' => $penyelia_keputusan,
            'penilaian_id' => $penilaian_id
        ]);
    }

    public function simpan_keputusan_penyelia(Request $request){
        $score_arr = json_decode($request->input('score_arr'));
        $penilaian_id = $request->input('penilaian_id');

        if(count($score_arr) > 0){
            foreach($score_arr as $sa){
                $avgId = $sa[0];
                $score = $sa[1];

                $model = PenilaiansCompetenciesPenyeliaAvg::find($sa[0]);
                $current_score = $model->score;
                $expected_score = $model->expected;
                $actual_expected_score = $model->actual_expected;

                //calculate gap for standard
                $gap = $score - $expected_score;

                $act_gap = $score - $actual_expected_score;
                $model->score = $score;
                if($gap > $expected_score){
                    $model->dev_gap = '+'.$gap;
                    $model->training = '--';
                }else if($gap < $expected_score){
                    $model->dev_gap = $gap;
                    $model->training = 'Required';
                }else if($gap == 0){
                    $model->dev_gap = 0;
                    $model->training = '--';
                }

                if($act_gap > $expected_score){
                    $model->actual_dev_gap = '+'.$gap;
                    $model->actual_training = '--';
                }else if($act_gap < $expected_score){
                    $model->actual_dev_gap = $gap;
                    $model->actual_training = 'Required';
                }else if($act_gap == 0){
                    $model->actual_dev_gap = 0;
                    $model->actual_training = '--';
                }
                $model->save();
            }

            $penilaian = Penilaian::find($penilaian_id);
            $penilaian->penyelia_update = 1;
            $penilaian->save();
        }

        return response()->json([
            'success' => 1,
            'data' => [
                'penilaian_id' => $penilaian_id,
                'profiles_id' => $penilaian->profiles_id,
            ]
        ]);
    }

    public function penyelia_accept_all(){
        $penyelia_id = Auth::user()->user_profile->id;

        $getPenilaian = Penilaian::where('penyelia_profiles_id', $penyelia_id)->where('penyelia_update', 1)->get();

        return view('segment.penyelia.pengesahan.history.index', [
            'penilaian' => $getPenilaian
        ]);
    }
}

