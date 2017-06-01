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
               <th>Usuario</th>
               <th>Nombre</th>
               <th>Apellido</th>
               <th>Fecha
                                <form action="" method="post">
                                 <div class="input-group date" id="datetimepicker1">
                                     <input style="width:200px;" type="text" class="form-control">
                                     <span  style="width: 0%;" class="input-group-addon">
                                         <span class="glyphicon glyphicon-calendar"></span>
                                     </span>
                                     <span style="width: 0%;" href="" id="confi" class="input-group-addon"><span class="glyphicon glyphicon-ok"></span></span>

                                 </div>
                               </form>


                         <script type="text/javascript">
                             $(function () {
                                 $('#datetimepicker1').datetimepicker({
                                   format: 'YYYY-MM-DD hh:mm:ss',
                                   locale:'es',
                                   dayViewHeaderFormat: 'YYYY-MM-DD'
                                 });
                              ;
                             });
                             $("#confi").click(function(){
                                $.post( "", { fecha: $("#datetimepicker1").find("input").val()} );
                                return false;
                             })

                         </script>
                     </div>
                 </div>
               </th>
               <th>
                 <div class="btn-group" role="group">
                   <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     Tipo
                  <span class="caret"></span>
                </button>
                    <ul class="dropdown-menu">
                      <li><a href="./0">Entrada</a></li>
                      <li><a href="./1">Salida</a></li>
                      <li><a href="./-1">Sin filtro</a></li>
                    </ul>
                  </div>
               </th>
             </thead>
             <tbody>
               @foreach($registros as $registro)
                <tr>
                  <td></td>
                  <td>{{$registro->user->username}}</td>
                  <td>{{$registro->user->name}}</td>
                  <td>{{$registro->user->lastname}}</td>
                  <td>{{$registro->created_at}}</td>
                  <td>@if ($registro->tipo_id ==0)
                    Entrada
                    @else
                   Salida
                   @endif</td>
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
