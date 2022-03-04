<?php

namespace App\Http\Controllers\Penyelaras;

use App\Http\Controllers\Controller;
use App\Models\Penilaian\Main\Penilaian;
use App\Models\Profiles\Profile;
use App\Models\Penilaian\DictBank\Set\DictBankSet;
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
}
