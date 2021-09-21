<?php
namespace App\Http\Controllers\Segment\Dashboard;

use App\Http\Controllers\Controller;
use Laratrust;

class DashboardController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        print_r(Laratrust::hasRole('Admin'));
    }
}
