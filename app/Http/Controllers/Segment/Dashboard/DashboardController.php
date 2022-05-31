<?php
namespace App\Http\Controllers\Segment\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Penilaian\Main\Penilaian;
use App\Models\Mykj\LJurusan;

class DashboardController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        // $data = Penilaian::checkPenilaian();
        // ////
        // //        echo '<pre>';
        // //        print_r($data);
        // //        echo '</pre>';
        // //        die();
        //         $jurusan = LJurusan::all();
        //         return view('segment.pengguna.dashboard.pengguna_dashboard', [
        //             'data' => $data,
        //             'jurusan' => $jurusan
        //         ]);

         return view('segment.dashboard.index');
    }
}
