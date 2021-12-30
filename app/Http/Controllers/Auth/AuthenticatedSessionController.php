<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laratrust;
use App\Models\Mykj\ListPegawai2;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $nokp = $request->input('nokp');

        if($nokp != 111){
            $user = User::where('nokp', $nokp)->first();
            if(!$user){
                $getMaklumat = ListPegawai2::getMaklumatPegawai($nokp);

                try {
                    $user = User::createOrUpdate($getMaklumat);
                }catch (Exception $e){
                    return redirect('/login');
                }
            }
        }

        $request->authenticate();

        $request->session()->regenerate();

        if(Laratrust::hasRole('Admin')){
            return redirect()->intended('/dashboard');
        }else{
//            if(Laratrust::hasRole('Pengguna')){
                return redirect()->intended('/dashboard/pengguna');
//            }
        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
