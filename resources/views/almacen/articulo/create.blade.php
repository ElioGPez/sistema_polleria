@extends('layouts.admin')
@section('contenido')
  <div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
      <h3>Nueva Articulo</h3>
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


  {!!Form::open(array('url'=>'almacen/articulo','method'=>'POST','autocomplete'=>'off','files'=>'true'))!!}
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
          <label for="">Categoria</label>
          <select class="form-control" name="idcategoria">
            @foreach ($categorias as $categoria)
              <option value="{{$categoria->idcategoria}}">{{$categoria->nombre}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="form-group">
          <label for="codigo">Codigo</label>
          <input type="text" name="codigo" value="{{old('codigo')}}" required class="form-control" placeholder="codigo ...">
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="form-group">
          <label for="stock">Stock</label>
          <input type="text" name="stock" value="{{old('stock')}}" required class="form-control" placeholder="stock ...">
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="form-group">
          <label for="descripcion">Descripcion</label>
          <input type="text" name="descripcion" value="{{old('descripcion')}}" required class="form-control" placeholder="descripcion ...">
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="form-group">
          <label for="precio_venta">Precio de Venta</label>
          <input type="text" name="precio_venta" value="{{old('precio_venta')}}" required class="form-control" placeholder="precio de venta ...">
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="form-group">
          <label for="imagen">Imagen</label>
          <input type="file" name="imagen" class="form-control" >
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
