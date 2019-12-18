@extends('layouts.admin')
@section('contenido')
  <div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
      <h3>Nueva Cliente</h3>
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


  {!!Form::open(array('url'=>'ventas/cliente','method'=>'POST','autocomplete'=>'off','files'=>'true'))!!}
  {!!Form::token()!!}
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="form-group">
          <label for="nombre">Nombre</label>
          <input type="text" name="nombre" value="{{old('nombre')}}" required class="form-control" placeholder="Nombre ...">
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="form-group">
          <label for="direccion">Direccion</label>
          <input type="text" name="direccion" value="{{old('direccion')}}" class="form-control" placeholder="Direccion ...">
        </div>
      </div>


      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="form-group">
          <label for="documento">Documento</label>
          <input type="text" name="documento" value="{{old('documento')}}" class="form-control" placeholder="Documento ...">
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="form-group">
          <label for="telefono">Telefono</label>
          <input type="text" name="telefono" value="{{old('telefono')}}" class="form-control" placeholder="telefono ...">
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="form-group">
          <label for="email">Email</label>
          <input type="text" name="email" value="{{old('email')}}"  class="form-control" placeholder="email ...">
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
