<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Registro;
use App\User;
class Administracion extends Controller
{

  public function __construct(){
    $this->middleware('auth');
      $this->middleware('isAdmin');
  }
    public function view(){
      return view('admin.home');
    }

    public function registrosView($filtro){
      $registros = Registro::all() ;
      if($filtro != -1){
        $registros = Registro::where('tipo_id',$filtro)->get();
      }
      return view('admin.registros',['registros'=>$registros]);
    }
    public function reportesView(){
      return view('admin.reportes');
    }
    public function listaUsuarios(){
      $usuario = User::all();
      return view('admin.listaUsuarios',['usuarios'=>$usuario]);
    }
    public function graficasView(){
      $usuario = User::all();
      return view('admin.graficas',['usuarios'=>$usuario]);
    }
}
