@extends('layouts.admin')
@section('contenido')

  <div class="row">
      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <h3>Clientes <a href="cliente/create"><button class="btn btn-success">Nuevo</button></a></h3>
        @include('ventas.cliente.search')
      </div>
  </div>

  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="table responsibe">
        <table class="table table-striped table-condensed table-hover table-bordered">
          <thead>
            <th>Id</th>
            <th>Nombre</th>
            <th>Nun Doc.</th>
            <th>Telefono</th>
            <th>Email</th>

            <th>Opciones</th>
          </thead>
          @foreach ($clientes as $per)
            <tr>
              <td>{{$per->idcliente}}</td>
              <td>{{$per->nombre}}</td>
              <td>{{$per->documento}}</td> 
              <td>{{$per->telefono}}</td>
              <td>{{$per->email}}</td>
              <td>
                <a href="{{URL::action('CuentaController@show',$per->idcliente)}}"><button class="btn btn-default">Cuenta</button></a>
                <a href="{{URL::action('ClienteController@edit',$per->idcliente)}}"><button class="btn btn-info">Editar</button></a>
                <a href="" data-target="#modal-delete-{{$per->idcliente}}" data-toggle="modal"><button class="btn btn-danger">Eliminar</button></a>
              </td>
            </tr>
            @include('ventas.cliente.modal')
          @endforeach
        </table>
      </div>
      {{$clientes->render()}}
    </div>
  </div>
@endsection
