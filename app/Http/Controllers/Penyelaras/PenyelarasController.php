<?php

namespace App\Http\Controllers\Penyelaras;

use App\Http\Controllers\Controller;
use App\Models\Mykj\ListPegawai2;
use App\Models\Penilaian\Main\Penilaian;
use App\Models\Profiles\Profile;
use App\Models\Penilaian\DictBank\Set\DictBankSet;
use App\Models\Regular\AgencyHierarchy;
use App\Models\Regular\AgencyPenyelaras;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class PenyelarasController extends Controller
{
    //
    public function load_main_page(Request $request) {
        return view('segment.penyelaras.index');
    }

    public function load_all_penilaians(Request $request) {
        $userId = Auth::user()->id;
        $profileIds = Profile::where('users_id',$userId)->pluck('id')->all();
        $agencyIds = AgencyPenyelaras::where('user_id',$userId)->pluck('agency_id')->all();
        $agencies = AgencyHierarchy::whereIn('id',$agencyIds)->all();


        $penilaians = Penilaian::whereIn('penyelia_profiles_id',$profileIds)->pluck('dict_bank_sets_id')->all();

        $model = DictBankSet::whereIn('id', $penilaians)->get();

            return DataTables::of($model)
                ->setRowAttr([
                    'data-bank-set-id' => function($data) {
                        return $data->id;
                    },
                    'data-bank-set-flag-id' => function($data) {
                        return $data->flag;
                    },
                ])
                ->addColumn('name', function($data){
                    return strtoupper($data->title);
                 })
                // ->addColumn('tkh_mula', function($data){
                //     return strtoupper($data->tkh_mula);
                // })
                // ->addColumn('tkh_tamat', function($data){
                //     return strtoupper($data->tkh_tamat);
                // })
               ->addColumn('year', function($data){
                    return $data->dictBankSetYear->year;
               })
                ->rawColumns(['action'])
                ->make(true);


    }

    public function add_penyelaras(Request $request) {
        $no_ic = $request->input('no_ic');
        $idAgensi = $request->input('agency_id');
        $getMaklumat = ListPegawai2::getMaklumatPegawai($no_ic);

        try {
            $user = User::createPenyelaras($getMaklumat,$idAgensi);
            return response()->json([
               'success' => 1,
            ]);
        }catch (Exception $e){
            return response()->json([
                'success' => 0,
            ]);
        }
    }

    public function delete_penyelaras(Request $request) {
        $agencyId = $request->input('agency_id');
        $userId = $request->input('user_id');


        try {
            $models = AgencyPenyelaras::where('user_id',$userId)->where('agency_id',$agencyId)->get();

            foreach($models as $model) {
                $model->delete();
            }

            return response()->json([
               'success' => 1,
            ]);
        }catch (Exception $e){
            return response()->json([
                'success' => 0,
            ]);
        }


    }

    public function load_detail(Request $request) {

    }
}
