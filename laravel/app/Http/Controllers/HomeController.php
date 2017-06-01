<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use QrCode;
use App\Registro;
use Session;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
          $this->middleware('isUserNormal');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function createMarcacion($tipo){
      $fecha = \Carbon\Carbon::now()->toDateTimeString();
      $hash = md5($fecha.Auth::user()->id);
      $registro = new Registro();
      $registro->hascode = $hash;
      $registro->estado_id=0; //QUiere decir que apenas se genero
      $registro->user()->associate(Auth::user()->id);
      $registro->created_at	 = $fecha; #coloco esta fehca para a la hora de validar el qr puedar "hacerle ingenieria inversa"
      if($tipo == 'entrada'){
        ##Se genera codigo a partir de la fecha y el id del usuario
        $registro->tipo_id=0; //el 0 es para las entradas
        $registro->save();
        Session::flash('hashcode',$hash);
      }else if($tipo == 'salida'){
        ##Se genera codigo a partir de la fecha y el id del usuario
        $registro->tipo_id=1; //el 0 es para las entradas
        $registro->save();
        Session::flash('hashcode',$hash);
      }
      return redirect()->route('home');


    }
}
