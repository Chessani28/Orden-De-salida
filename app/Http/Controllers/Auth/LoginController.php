<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;



class LoginController extends Controller
{

    use AuthenticatesUsers;

    protected function authenticated(Request $request, $user)
    {
        if ($user->role->name === 'programacion') {
            return redirect(RouteServiceProvider::HOME);

        } elseif ($user->role->name === 'vendedor'){
            return redirect(RouteServiceProvider::HOME2);

        } elseif ($user->role->name === 'instalador'){
            return redirect(RouteServiceProvider::HOME3);

        } elseif ($user->role->name === 'verificacion'){
            return redirect(RouteServiceProvider::HOME4);

        } else {
            $mensajeError = "Usuario incorrecto";
            echo $mensajeError;
        }

    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    protected $redirectToo = RouteServiceProvider::HOME2;

    protected $redirectTooo = RouteServiceProvider::HOME3;



    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

}
