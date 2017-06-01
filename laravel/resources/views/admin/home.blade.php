@extends('layouts.app')
@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-6 col-sm-offset-3">
      <div class="panel panel-default">
        <div class="panel-body">
                <a href="{{route('registerView')}}"> Crear Usuarios</a>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-sm-offset-3">
      <div class="panel panel-default">
        <div class="panel-body">
            <a href="{{route('listaUsuarios')}}">Lista de Usuarios</a>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-sm-offset-3">
      <div class="panel panel-default">
        <div class="panel-body">
            <a href="{{route('resportesViewAdmin')}}">Reportes</a>
        </div>
      </div>
    </div>


  </div>

</div>
@endsection
