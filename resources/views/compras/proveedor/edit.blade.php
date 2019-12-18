@extends('layouts.admin')
@section('contenido')
  <div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
      <h3>Editar proveedor: {{$persona->razonsocial}}</h3>
      @if (count($errors)>0)
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{$error}}</li>
            @endforeach
          </ul>
        </div>
      @endif
    </div>
  </div>
  
  {!!Form::model($persona,['method'=>'PATCH','route'=>['compras.proveedor.update',$persona->idproveedor]])!!}
  {!!Form::token()!!}
  <div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
      <div class="form-group">
        <label for="razonsocial">Razon Social</label>
        <input type="text" name="razonsocial" value="{{$persona->razonsocial}}" required class="form-control" placeholder="Razon Social ...">
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
      <div class="form-group">
        <label for="direccion">Direccion</label>
        <input type="text" name="direccion" value="{{$persona->direccion}}" class="form-control" placeholder="Direccion ...">
      </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
      <div class="form-group">
        <label for="cuit">CUIT</label>
        <input type="text" name="cuit" value="{{$persona->cuit}}" class="form-control" placeholder="CUIT ...">
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
      <div class="form-group">
        <label for="telefono">Telefono</label>
        <input type="text" name="telefono" value="{{$persona->telefono}}" class="form-control" placeholder="telefono ...">
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
      <div class="form-group">
        <label for="email">Email</label>
        <input type="text" name="email" value="{{$persona->email}}"  class="form-control" placeholder="email ...">
      </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
      <div class="form-group">
        <button type="submit" name="guardar" class="btn btn-primary">Guardar</button>
        <button type="reset" name="cancelar" class="btn btn-danger">Cancelar</button>
      </div>
    </div>
  </div>
  {!!Form::close()!!}
@endsection
