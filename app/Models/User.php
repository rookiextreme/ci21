<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Laratrust\Traits\LaratrustUserTrait;

use App\Models\Profiles\Profile;
use App\Models\Profiles\ProfilesAlamatPejabat;
use App\Models\Profiles\ProfilesCawanganLog;
use App\Models\Profiles\ProfilesTelefon;
use App\Models\LaratrustModels\RoleUser;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function user_profile(){
        return $this->hasOne('App\Models\Profiles\Profile', 'users_id', 'id');
    }

    public function users_roles(){
        return $this->hasOne('App\Models\LaratrustModels\RoleUser', 'user_id', 'id');
    }

    public static function createOrUpdate($peg_maklumat){
        $user = User::where('nokp', $peg_maklumat['nokp'])->first();
        if(!$user){
            $user = new User;
            $user->nokp = $peg_maklumat['nokp'];
            $user->name = $peg_maklumat['name'];
            $user->email = $peg_maklumat['email'];
            $user->password = Hash::make('123123123');

            if($user->save()){
                $profile = new Profile;
                $profile->users_id = $user->id;
                $profile->flag = 1;
                $profile->delete_id = 0;
                if($profile->save()){
                    $cawanganLogs = new ProfilesCawanganLog();
                    $cawanganLogs->profiles_id = $profile->id;
                    $cawanganLogs->sektor = $peg_maklumat['waran_split']['sektor'];
                    $cawanganLogs->cawangan = $peg_maklumat['waran_split']['cawangan'];
                    $cawanganLogs->bahagian = $peg_maklumat['waran_split']['bahagian'];
                    $cawanganLogs->unit = $peg_maklumat['waran_split']['unit'];
                    $cawanganLogs->penempatan = $peg_maklumat['waran_split']['waran_penuh'];
                    $cawanganLogs->sektor_name = $peg_maklumat['waran_name']['sektor'];
                    $cawanganLogs->cawangan_name = $peg_maklumat['waran_name']['cawangan'];
                    $cawanganLogs->bahagian_name = $peg_maklumat['waran_name']['bahagian'];
                    $cawanganLogs->unit_name = $peg_maklumat['waran_name']['unit'];
                    $cawanganLogs->penempatan_name = $peg_maklumat['waran_name']['waran_penuh'];
                    $cawanganLogs->tahun = date('Y');
                    $cawanganLogs->gred = $peg_maklumat['gred'];
                    $cawanganLogs->flag = 1;
                    $cawanganLogs->delete_id = 0;

                    if($cawanganLogs->save()){
                        $profileTelefon = new ProfilesTelefon;
                        $profileTelefon->profiles_id = $profile->id;
                        $profileTelefon->no_tel_bimbit = $peg_maklumat['tel_bimbit'];
                        $profileTelefon->no_tel_pejabat = $peg_maklumat['tel_pejabat'];
                        $profileTelefon->flag = 1;
                        $profileTelefon->delete_id = 0;

                        if($profileTelefon->save()){
                            $alamat = new ProfilesAlamatPejabat;
                            $alamat->profiles_id = $profile->id;
                            $alamat->alamat = $peg_maklumat['alamat_pejabat'];
                            $alamat->flag = 1;
                            $alamat->delete_id = 0;

                            if($alamat->save()){
                                $role_user = new RoleUser;
                                $role_user->user_id = $user->id;
                                $role_user->role_id = 2;
                                $role_user->user_type = 'App\Models\User';

                                if($role_user->save()){
                                    return 1;
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public static function getPengguna($profile_id){
        $profile = Profile::find($profile_id);
        $profile_user = $profile->profile_Users;

        $data = [
            'user_info' => [
                'user_id' => $profile_user->id,
                'name' => $profile_user->name,
                'nric' => $profile_user->nokp,
                'penempatan' => $profile->profile_Profile_cawangan_log_active->penempatan_name ?? '',
                'gred' => $profile->profile_Profile_cawangan_log_active->gred ?? '',
                'telefon' => [
                    'pejabat' => $profile->profile_Profile_telefon->no_tel_pejabat ?? '',
                    'bimbit' => $profile->profile_Profile_telefon->no_tel_bimbit ?? '',
                ]
            ],
            'roles' => User::getPenggunaRoles($profile_user->id)
        ];

        return $data;
    }

    public static function getPenggunaRoles($profile_id) : array{
        $data = [];
        $model = RoleUser::where('user_id', $profile_id)->get();

        if(count($model) > 0){
            foreach ($model as $roles){
                $data[] = [
                    'id' => $roles->roleUserRole->id,
                    'name' => $roles->roleUserRole->name,
                ];
            }
        }
        return $data;
    }

    public static function roleUpdate($data){
        $roleArr = json_decode($data['roleArr']);
        $user_id = $data['user_id'];

        RoleUser::where('user_id', $user_id)->delete();

        foreach($roleArr as $r){
            $newQuery = new RoleUser;
            $newQuery->user_id = $user_id;
            $newQuery->role_id = $r;
            $newQuery->user_type = 'App\Models\User';
            $newQuery->save();
        }

        return 1;
    }
}
