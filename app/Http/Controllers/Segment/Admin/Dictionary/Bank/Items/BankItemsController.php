<?php
namespace App\Http\Controllers\Segment\Admin\Dictionary\Bank\Items;

use App\Http\Controllers\Controller;

class BankItemsController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($penilaian_id){

    }
}
