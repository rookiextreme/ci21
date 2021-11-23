<?php
namespace App\Http\Controllers\Segment\Pengguna\PenilaianScore;

use App\Http\Controllers\Controller;
use App\Models\Penilaian\Main\Penilaian;
use App\Models\Penilaian\Main\PenilaiansCompetency;
use App\Models\Penilaian\Main\PenilaiansJawapan;
use Illuminate\Http\Request;

class PenilaianScoreController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($penilaian_id){
        $getPenilaianCompetency = PenilaiansCompetency::getScoreCompetencyQuestion($penilaian_id);

        if($getPenilaianCompetency['penilaian_status'] == 0){
            return view('segment.pengguna.penilaianscore.index', [
                'penilaian_id' => $penilaian_id,
                'data' => $getPenilaianCompetency['data']
            ]);
        }else{
            return view('segment.pengguna.penilaianscore.complete',[
                'penilaian_id' => $getPenilaianCompetency['user_penilaian_id']
            ]);
        }
    }

    public function update_score(Request $request){
        $quesArr = json_decode($request->input('quesArr'));
        $competency_id = $request->input('competency_id');

        if(!empty($quesArr)){
            foreach($quesArr as $qa){
                $score_id = $qa[0];
                $score = $qa[1];

                $model = PenilaiansJawapan::find($score_id);
                $model->score = $score;
                $model->save();
            }
        }

        $checkComCompete = PenilaiansCompetency::find($competency_id);
        if(count($checkComCompete->penilaianCompetencyJawapanNotAns) == 0){
            $checkComCompete->status = 1;
            $checkComCompete->save();
        }
        $penilaian_incomplete_com = $checkComCompete->penilaianCompetencyPenilaian->penilaianPenilaianComCheckIfDone;
        if(count($penilaian_incomplete_com) == 0){
            $penilaianComplete = Penilaian::find($checkComCompete->penilaianCompetencyPenilaian->id);
            $penilaianComplete->status = 1;
            $penilaianComplete->save();
        }

        return response()->json([
            'success' => 1
        ]);
    }

    public function kemaskini_score(Request $request){
        $penilaian_id = $request->input('penilaian_id');

        $penilaian_reset = Penilaian::find($penilaian_id);
        $penilaian_reset->status = 0;
        $penilaian_reset->save();

        $model = PenilaiansCompetency::where('penilaians_id' , $penilaian_id)->get();
        if(count($model) > 0){
            foreach($model as $m){
                $m->status = 0;
                $m->save();
            }
        }
        return response()->json([
            'success' => 1,
            'trigger' => 1
        ]);
    }

    public function hantar_score(Request $request){
        $penilaian_id = $request->input('penilaian_id');

        $penilaian_hantar = Penilaian::find($penilaian_id);
        $penilaian_hantar->status = 2;
        $penilaian_hantar->save();

        return response()->json([
            'success' => 1,
            'trigger' => 2
        ]);
    }
}
