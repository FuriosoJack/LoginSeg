<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
//use Illuminate\Foundation\Auth\RegistersUsers;
use App\Rol;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    //use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    //protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

     public function view(){
       return view('admin.register',['roles'=>Rol::all()]);
     }
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'lastname'=>'required|string|max:255',
            'username'=>'required|string|max:191|unique:users',
            'rol' => 'required|integer',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
      //dd($data['rol']);
      $user = new User();
      $user->fill($data);
      $user->password = md5($data['password']);
      $user->save();
      $user->roles()->attach($data['rol']);

    }
    public function register(Request $request){

      $this->validator($request->all())->validate();
      $this->create($request->except('_token', 'password_confirmation'));
      return redirect()->route('registerView');
    }
}
