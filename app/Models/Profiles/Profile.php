<?php
namespace App\Models\Profiles;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    public function profile_Users(){
        return $this->hasOne('App\User', 'id', 'users_id');
    }

    public function profile_Profile_cawangan_log(){
        return $this->hasMany('App\Models\Profiles\ProfilesCawangansLog', 'profiles_id', 'id');
    }

    public function profile_Profile_cawangan_log_active(){
        return $this->hasOne('App\Models\Profiles\ProfilesCawangansLog', 'profiles_id', 'id')->orderBy('id', 'desc');
    }

    public function profile_Profile_telefon(){
        return $this->hasMany('App\Models\Profiles\ProfilesTelefon', 'profiles_id', 'id');
    }

    public function profile_Profile_alamat_pejabat(){
        return $this->hasMany('App\Models\Profiles\ProfilesAlamatPejabat', 'profiles_id', 'id');
    }

}
