<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;
use Auth;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

  //  use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
     use AuthenticatesUsers;
    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
    }



    public function username()
    {
        return 'username';
    }

    public function view()
    {

        return view('auth.login');
    }

    /*public function login(Request $requets){
     if(!(empty($requets->username) && empty($requets->password))){

       //Busco el usuario
       $username = User::where('username',$requets->username)->first();
       //Compruebo si existe
       if(!empty($username)){
         //verifico el password
           $passwordTMP = bcrypt($requets->password);
           dd(var_dump($requets->get('password')));
         if($username->password == bcrypt($requets->password)){
           auth()->login($username);
          if($username->isRol('adm')){
             //Es un administrador
             return redirect()->route('viewAdmin');
           }else{
             return redirect()->route('home');
           }
        }else{
           //password invalido
           return redirect()->route('login'); //Por ahora redirije
         }

       }else{
         //NO existe
         return redirect()->route('login');
       }
     }else{
       //NO ingresa
       return redirect()->route('login');
     }

    }*/
}
