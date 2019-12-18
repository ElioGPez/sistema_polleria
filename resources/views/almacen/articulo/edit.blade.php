@extends('layouts.admin')
@section('contenido')
  <div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
      <h3>Editar Articulo: {{$articulo->nombre}}</h3>
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
  {!!Form::model($articulo,['method'=>'PATCH','route'=>['almacen.articulo.update',$articulo->idarticulo],'files'=>'true'])!!}
  {!!Form::token()!!}
  <div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
      <div class="form-group">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" value="{{$articulo->nombre}}" required class="form-control">
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
      <div class="form-group">
        <label for="categoria">Categoria</label>
        <select class="form-control" name="idcategoria">
          @foreach ($categorias as $categoria)
            @if ($categoria->idcategoria ==$articulo->idcategoria)
              <option selected value="{{$categoria->idcategoria}}">{{$categoria->nombre}}</option>
            @else
              <option  value="{{$categoria->idcategoria}}">{{$categoria->nombre}}</option>
            @endif
          @endforeach
        </select>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
      <div class="form-group">
        <label for="codigo">Codigo</label>
        <input type="text" name="codigo" value="{{$articulo->codigo}}" required class="form-control">
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
      <div class="form-group">
        <label for="stock">Stock</label>
        <input type="text" name="stock" value="{{$articulo->stock}}" required class="form-control" >
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
      <div class="form-group">
        <label for="descripcion">Descripcion</label>
        <input type="text" name="descripcion" value="{{$articulo->descripcion}}" required class="form-control">
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
      <div class="form-group">
        <label for="precio_venta">Precio de Venta</label>
        <input type="text" name="precio_venta" value="{{$articulo->precio_venta}}" required class="form-control">
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
      <div class="form-group">
        <label for="estado">Estado</label>
        <select class="form-control" name="estado">
          @if ($articulo->estado=='Inactivo')
            <option selected value="Inactivo">Inactivo</option>
            <option value="Activo">Activo</option>
          @else
            <option value="Inactivo">Inactivo</option>
            <option selected value="Activo">Activo</option>
          @endif
        </select>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
      <div class="form-group">
        <label for="imagen">Imagen</label>
        <input type="file" name="imagen" class="form-control" value="{{$articulo->imagen}}">
        @if (($articulo->imagen)!="")
          <img src="{{asset('imagenes/articulos/'.$articulo->imagen)}}" width="200px" height="200px">
        @endif
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
