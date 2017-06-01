@extends('layouts.app')
@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-sm-offset-1">
      <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Reportes De Registros</h3>
         </div>
        <div class="panel-body">
          <table class="table">
            <thead>
              <th>#</th>
              <th>Nombre</th>
              <th>Apellido</th>
              <th>Username</th>
              <th>Roles</th>
            </thead>
            <tbody>
              @foreach($usuarios as $usuario)
              <tr>
                <td>{{$usuario->id}}</td>
                <td>{{$usuario->name}}</td>
                <td>{{$usuario->lastname}}</td>
                <td>{{$usuario->username}}</td>
                <td>@foreach($usuario->roles as $rol)
                  {{$rol->description}}
                  @endforeach
              </tr>
              @endforeach
            </tbody>
          </table>
      </div>
    </div>
  </div>
</div>
</div>
@endsection
