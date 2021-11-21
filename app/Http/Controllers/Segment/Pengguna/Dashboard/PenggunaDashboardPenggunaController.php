<?php
namespace App\Http\Controllers\Segment\Pengguna\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Penilaian\Main\Penilaian;

class PenggunaDashboardPenggunaController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $data = Penilaian::checkPenilaian();
//        echo '<pre>';
//        print_r($data);
//        echo '</pre>';
//        die();
        return view('segment.pengguna.dashboard.pengguna_dashboard', [
            'data' => $data
        ]);
    }
}
