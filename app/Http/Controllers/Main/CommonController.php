<?php
namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\LaratrustModels\Role;
use App\Models\Mykj\ListPegawai2;
use App\Models\Mykj\Peribadi;
use App\Models\Mykj\LWaranPej;
use App\Models\Regular\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommonController extends Controller{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listing(Request $request)
    {
        $model = $request->input('model');
        $queryString = json_decode($request->input('queryString'));
        $data = [];

        if($model == 'Role'){
            $query = Role::all();

            foreach($query as $list){
                $data[] = array(
                    'label' => $list->display_name,
                    'value' => $list->id
                );
            }
        }

        return response()->json([
            'success' => 1,
            'data' => $data,
        ]);
    }

    public function pengguna_carian(Request $request){
        $data = [];
        $search_term = $request->input('q');
        $peribadi = ListPegawai2::where('nokp', 'ilike', '%'.$search_term.'%')
            ->orWhereRaw("LOWER(nama) ilike '%".$search_term."%'")->limit(10)->get();

        if(count($peribadi) != 0){
            foreach($peribadi as $p){
                $data[] = array(
                    'id' => $p->nokp,
                    'text' => $p->nama.' - '.$p->nokp
                );
            }
        }

        return response()->json([
            'data' => $data
        ]);
    }

    public function pengguna_maklumat(Request $request) : \Illuminate\Http\JsonResponse
    {
        $no_ic = $request->input('no_ic');
        try {
            $getMaklumat = ListPegawai2::getMaklumatPegawai($no_ic);
            return response()->json([
                'success' => 1,
                'data' => $getMaklumat
            ]);
        } catch(Exception $e) {
            return response()->json([
                'success' => 0,
            ]);
        }
    }

    public static function getYearList(){
        $model = Year::all()->toArray();
        $data = [];

        foreach($model as $y){
            $data[] = [
                'id' => $y['id'],
                'year' => $y['year'],
            ];
        }

        return $data;
    }

    public static function upload_image($photo, $folder){
        $filename = $photo->getClientOriginalName();
        $extension = $photo->getClientOriginalExtension();
        $image = str_replace(' ', '+', $photo);
        $imagename = str_random(10).'.'. $extension;
        $photo->move($folder, $imagename);

        return $imagename;
    }

    public function search_agency(Request $request) {
        $data = [];
        $search_term = $request->input('q');
        $agencies = LWaranPej::where(DB::raw('UPPER(waran_pej)'),'like','%'.strtoupper($search_term).'%')
            ->orWhere('kod_waran_pej', 'like', $search_term.'%')
            ->limit(20)->get();

            if(count($agencies) != 0){
                foreach($agencies as $p){
                    $data[] = array(
                        'id' => $p->kod_waran_pej.'-'.strtoupper($p->waran_pej),
                        'text' => strtoupper($p->waran_pej)." - ".$p->kod_waran_pej
                    );
                }
            }

            return response()->json([
                'data' => $data
            ]);
    }
}
