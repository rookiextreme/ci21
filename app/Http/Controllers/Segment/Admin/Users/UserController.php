<?php
namespace App\Http\Controllers\Segment\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\Mykj\ListPegawai2;
use App\Models\Profiles\Profile;
use App\Models\Profiles\ProfilesCawanganLog;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use DB;

class UserController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('segment.admin.user.index');
    }

    public function pengguna_list(){
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

    public function pengguna_tambah(Request $request){
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

    public function pengguna_aktif(Request $request){
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

    public function pengguna_delete(Request $request){
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
