@extends('layouts.app')
@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-6 ">
      <div class="panel panel-default">
        <div class="panel-body">
                <a href="{{route('graficasView')}}">Graficos</a>
        </div>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="panel panel-default">
        <div class="panel-body">
            <a href="{{route('registrosViewAdmin',['filtro'=>-1])}}">Registros</a>
        </div>
      </div>
    </div>


  </div>

</div>
@endsection
