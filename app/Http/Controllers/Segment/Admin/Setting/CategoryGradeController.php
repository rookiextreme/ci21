<?php
namespace App\Http\Controllers\Segment\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Main\CommonController;
use App\Models\Profiles\ProfilesCawanganLog;
use App\Models\Regular\Year;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class  CategoryGradeController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //Year Page
    public function year_index(){
        return view('segment.admin.setting.categorygrade.year.index');
    }

    public function kategori_grade_year_list(){
        $model = CommonController::getYearList();

        return DataTables::of($model)
            ->setRowAttr([
                'data-year-id' => function($data) {
                    return $data['id'];
                },
            ])
            ->addColumn('year', function($data){
                return strtoupper($data['year']);
            })
            ->rawColumns(['active', 'action'])
            ->make(true);
    }
    //End Year Page

    //Start of Main Module
    public function index($year_id){
        return view('segment.admin.setting.categorygrade.category.index', [
            'year_id' => $year_id,
            'year' => Year::findOne($year_id)
        ]);
    }

    public function kategori_grade_list(){
        $model = DB::select('SELECT
            p.id as p_id,
            u.id as u_id,
            u.name as u_name,
            u.email as u_email
            From profiles p
                join users u on p.users_id = u.id
                join role_user ru on u.id = ru.user_id
            where ru.role_id = 2 and p.delete_id != 1;
        ');

        return DataTables::of($model)
            ->setRowAttr([
                'data-profile-id' => function($data) {
                    return $data->p_id;
                },
                'data-user-id' => function($data) {
                    return $data->u_id;
                },
            ])
            ->addColumn('nama', function($data){
                return strtoupper($data->u_name);
            })
            ->addColumn('email', function($data){
                return strtoupper($data->u_email);
            })
            ->addColumn('penempatan', function($data){
                return ProfilesCawanganLog::where('profiles_id', $data->p_id)->orderBy('id', 'desc')->limit(1)->first()->penempatan_name;
            })
            ->rawColumns(['active', 'action'])
            ->make(true);
    }

    public function kategori_grade_tambah(Request $request){
        $no_ic = $request->input('no_ic');
        $getMaklumat = ListPegawai2::getMaklumatPegawai($no_ic);
        try {
            $user = User::createOrUpdate($getMaklumat);
            return response()->json([
                'success' => 1,
            ]);
        }catch (Exception $e){
            return response()->json([
                'success' => 0,
            ]);
        }
    }

    public function kategori_grade_aktif(Request $request){
        $profile_id = $request->input('profile_id');
        $process = $this->aktif_delete($profile_id, 1);

        return response()->json([
            'success' => $process['success'],
            'data' => [
                'profile_id' => $process['profile_id'],
                'flag' => $process['flag']
            ]
        ]);
    }

    public function kategori_grade_delete(Request $request){
        $profile_id = $request->input('profile_id');
        $process = $this->aktif_delete($profile_id, 2);

        return response()->json([
            'success' => $process['success'],
            'data' => [
                'profile_id' => $process['profile_id'],
            ]
        ]);
    }

    public function aktif_delete($profile_id, $trigger) : array{
        $model = Profile::find($profile_id);
        if($trigger == 1){
            $model->flag = $model->flag == 1 ? 0 : 1;
        }else{
            $model->delete_id = 1;
        }

        return [
            'success' => $model->save() ? 1 : 0,
            'profile_id' => $model->id,
            'flag' => $model->flag,
        ];
    }
}
