@extends('layouts.admin')
@section('contenido')
  <div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
      <h3>Editar Cliente: {{$persona->nombre}}</h3>
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
  {!!Form::model($persona,['method'=>'POST','route'=>['ventas.cliente.update',$persona->idpersona]])!!}
  {!!Form::token()!!}
  <div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
      <div class="form-group">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" value="{{$persona->nombre}}" required class="form-control" placeholder="Nombre ...">
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
      <div class="form-group">
        <label for="direccion">Direccion</label>
        <input type="text" name="direccion" value="{{$persona->direccion}}" class="form-control" placeholder="Direccion ...">
      </div>
    </div>



    <!--div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
      <div class="form-group">
        <label for="">Documento</label>
        <select class="form-control" name="tipo_documento">
          @if ($persona->tipo_documento=='DNI')
            <option value="DNI" selected>DNI</option>
            <option value="RUC" >RUC</option>
            <option value="PAS" >PAS</option>
          @elseif ($persona->tipo_documento=='RUC')
            <option value="DNI" >DNI</option>
            <option value="RUC" selected>RUC</option>
            <option value="PAS" >PAS</option>
          @else
            <option value="DNI" >DNI</option>
            <option value="RUC" >RUC</option>
            <option value="PAS" selected>PAS</option>
          @endif
        </select>
      </div>
    </div-->
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
      <div class="form-group">
        <label for="documento">Documento</label>
        <input type="text" name="documento" value="{{$persona->documento}}" class="form-control" placeholder="Documento ...">
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
