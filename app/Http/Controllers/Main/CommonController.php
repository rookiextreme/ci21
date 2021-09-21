<?php
namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Mykj\ListPegawai2;
use App\Models\Mykj\Peribadi;
use Illuminate\Http\Request;

class CommonController extends Controller{
    public function listing(){

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

    public static function upload_image($photo, $folder){
        $filename = $photo->getClientOriginalName();
        $extension = $photo->getClientOriginalExtension();
        $image = str_replace(' ', '+', $photo);
        $imagename = str_random(10).'.'. $extension;
        $photo->move($folder, $imagename);

        return $imagename;
    }
}
