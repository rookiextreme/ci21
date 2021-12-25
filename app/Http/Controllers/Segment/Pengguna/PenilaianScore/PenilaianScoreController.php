<?php
namespace App\Http\Controllers\Segment\Pengguna\PenilaianScore;

use App\Http\Controllers\Controller;
use App\Models\Penilaian\Main\Penilaian;
use App\Models\Penilaian\Main\PenilaiansCompetency;
use App\Models\Penilaian\Main\PenilaiansJawapan;
use CreatePenilaiansTable;
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
            $calculateCom = PenilaiansCompetency::comCalculate($checkComCompete);
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

    public function score_keputusan($penilaian_id){
        $penilaian = Penilaian::where('id', $penilaian_id)->first();
        $data['id'] = $penilaian_id;
        $data['penilaian'] = [];

        $pc = $penilaian->penilaianPenilaianCom;

        if(count($pc)){
            $totalScoreAll = 0;
            $totalItemAll = 0;
            $totalExpectedAll = 0;
            $totalDevGapAll = 0;

            $totalActualScoreAll = 0;
            $totalActualItemAll = 0;
            $totalActualExpectedAll = 0;
            $totalActualDevGapAll = 0;

            foreach($pc as $pcList){
                $avg = $pcList->penilaianCompetencyAvg;
                $scoreTotal = 0;
                $totalItem = 0;
                $expectedTotal = 0;
                $gapTotal = 0;

                $scoreActualTotal = 0;
                $totalActualItem = 0;
                $expectedActualTotal = 0;
                $gapActualTotal = 0;

                $data['penilaian'][$pcList->id]['name'] = $pcList->penilaianCompetencyActualCom->dictBankCompetencyTypeScaleBridgeCompetency->name;

                if(count($avg) > 0){
                    foreach($avg as $av){
                        //For All
                        $totalScoreAll = $totalScoreAll + $av->score;
                        $totalItemAll++;
                        $totalDevGapAll = $totalDevGapAll + ($av->dev_gap);
                        $totalExpectedAll = $totalExpectedAll + ($av->expected);

                        $totalActualScoreAll = $totalScoreAll + $av->score;
                        $totalActualItemAll++;
                        $totalActualExpectedAll = $totalActualExpectedAll + ($av->actual_expected);
                        $totalActualDevGapAll =  $totalActualDevGapAll + ($av->actual_dev_gap);
                        //End All

                        $totalItemAll++;
                        $totalItem++;
                        $scoreTotal = $scoreTotal + $av->score;
                        $expectedTotal = $expectedTotal + ($av->expected);
                        $gapTotal = $gapTotal + ($av->dev_gap);

                        $totalActualItem++;
                        $scoreActualTotal = $scoreActualTotal + $av->score;
                        $expectedActualTotal = $expectedActualTotal + ($av->actual_expected);
                        $gapActualTotal = $gapActualTotal + ($av->actual_dev_gap);

                        $data['penilaian'][$pcList->id]['competencies'][$av->penilaianAvgItem->title_eng] = [
                            'score' => $av->score,
                            'expected' => $av->expected,
                            'gap' => $av->dev_gap,
                            'training' => $av->training,
                            'actual_expected' => $av->actual_expected,
                            'actual_gap' => $av->actual_dev_gap,
                            'actual_training' => $av->actual_training
                        ];
                    }
                    $data['penilaian'][$pcList->id]['total_score'] = $scoreTotal;
                    $data['penilaian'][$pcList->id]['total_item'] = $totalItem;
                    $data['penilaian'][$pcList->id]['avg_com_score'] = round($scoreTotal / $totalItem, 2);
                    $data['penilaian'][$pcList->id]['avg_com_expected'] = round($expectedTotal / $totalItem, 2);
                    $data['penilaian'][$pcList->id]['avg_com_gap'] = round($gapTotal / $totalItem, 2);
                    $data['penilaian'][$pcList->id]['actual_avg_com_score'] = round($scoreActualTotal / $totalActualItem, 2);
                    $data['penilaian'][$pcList->id]['actual_avg_com_expected'] = round($expectedActualTotal / $totalActualItem, 2);
                    $data['penilaian'][$pcList->id]['actual_avg_com_gap'] = round($gapActualTotal / $totalActualItem, 2);
                }
                $data['jumlah']['avg_com_score'] = round( $totalScoreAll / $totalItemAll,2);
                $data['jumlah']['avg_com_expected'] = round($totalExpectedAll / $totalItemAll,2);
                $data['jumlah']['avg_com_gap'] = round( $totalDevGapAll / $totalItemAll,2);

                $data['jumlah']['actual_avg_com_score'] = round( $totalActualScoreAll / $totalActualItem,2);
                $data['jumlah']['actual_avg_com_expected'] = round($totalActualExpectedAll / $totalActualItem,2);
                $data['jumlah']['actual_avg_com_gap'] = round( $totalActualDevGapAll / $totalActualItem,2);
            }
        }

//        echo '<pre>';
//        print_r($data);
//        echo '</pre>';
//        die();
        return view('segment.pengguna.penilaianscore.keputusan', [
            'name' => $penilaian->penilaianDictBankSet->title,
            'data' => $data
        ]);
    }
}
