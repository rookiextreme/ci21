<?php
namespace App\Http\Controllers\Segment\Admin\Dictionary\Collection;

use App\Http\Controllers\Controller;

class ColController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

    }
}
