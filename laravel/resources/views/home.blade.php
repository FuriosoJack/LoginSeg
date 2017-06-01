@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">Menu Principal</div>

                <div class="panel-body text-center">
                  <p>Seleccione la accion que va a realizar.</p>
                   <a href="{{route('marcar',['tipo'=>'entrada'])}}" class="btn btn-primary">Entrada</a>
                    <a href="{{route('marcar',['tipo'=>'salida'])}}"  class="btn btn-success">Salida</a>
                    @if(Session::has('hashcode'))
                      {!!QrCode::size(300)->generate(Session::get('hashcode'))!!}

                  @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<!---
Es necesario instalar php-dg para el codigo qr
*/
-->
