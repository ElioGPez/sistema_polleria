@extends('layouts.admin')
@section('contenido')
  <div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
      <h3>Nuevo Ingreso</h3>
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


  {!!Form::open(array('url'=>'compras/ingreso','method'=>'POST','autocomplete'=>'off'))!!}
  {!!Form::token()!!}
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="form-group">
          <label for="proveedor">Proveedor</label>
          <select class="form-control selectpicker" data-live-search="true" name="idproveedor" id="idproveedor">
            @foreach ($personas as $persona)
              <option value="{{$persona->idproveedor}}">{{$persona->razonsocial  }}</option>
            @endforeach
          </select>
        </div>
      </div>


    </div>
    <div class="row">
      <div class="panel panel-primary">
        <div class="panel-body">
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
              <label for="">Articulo</label>
              <select class="form-control selectpicker" data-live-search="true" name="pidarticulo" id="pidarticulo">
                @foreach ($articulos as $articulo)
                  <option value="{{$articulo->idarticulo}}">{{$articulo->articulo}}</option>
                @endforeach
              </select>
            </div>
          </div>
          {{-- cantidad --}}
          <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <div class="form-group">
              <label for="cantidad">Cantidad</label>
              <input type="number" name="pcantidad" value="" id="pcantidad" class="form-control" placeholder="cantidad">
            </div>
          </div>
          {{-- preciocompra --}}
          <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <div class="form-group">
              <label for="precio_compra">Precio Compra</label>
              <input type="number" name="pprecio_compra" value="" id="pprecio_compra" class="form-control" placeholder="P. Compra">
            </div>
          </div>
          {{-- precio venta --}}
          <!-- div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <div class="form-group">
              <label for="precio_venta">Precio Venta</label>
              <input type="number" name="pprecio_venta"  id="pprecio_venta" value="" class="form-control" placeholder="P. venta">
            </div>
          </div -->
          <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <div class="form-group">
              <button type="button" id="bt_add" class="btn btn-primary">Agregar</button>
            </div>
          </div>
 
          <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
            <table class="table table-striped table-bordered table-condensed table-hover" id="detalles">
              <thead style="background-color:#A9D0F5">
                <th>Opciones</th>
                <th>Articulo</th>
                <th>Cantidad</th>
                <th>Precio Compra</th>
                <!-- th>Precio Venta</th -->
                <th>Subtotal</th>
              </thead>
              <tfoot>
                <th>TOTAL</th>
                <th></th>
                <th></th>
                <th></th>
                <th><h4 id="total">$ 0.00</h4><input type="hidden" name="total_ingreso" id="total_ingreso" ></th>
              </tfoot>
              <tbody>

              </tbody>
            </table>
          </div>

        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" id="guardar">
        <div class="form-group">
          <input type="hidden" name="_token" value="{{csrf_token()}}"></input>
          <button type="submit" name="guardar" class="btn btn-primary">Guardar</button>
          <button type="reset" name="cancelar" class="btn btn-danger">Cancelar</button>
        </div>
      </div>
    </div>
  {!!Form::close()!!}


  @push('scripts')
    <script>
      $(document).ready(function(){
        $('#bt_add').click(function(){
          agregar();
        })
      });

      total =0;
      var contador=0;
      subtotal=[];
      $("#guardar").hide();
      function agregar(){
          idarticulo=$("#pidarticulo").val();
          articulo=$("#pidarticulo option:selected").text();
          cantidad=$("#pcantidad").val();
          precio_compra=$("#pprecio_compra").val();
          //valido los datos
          if (idarticulo!="" && cantidad!="" && cantidad>0 && precio_compra!="") {
            subtotal[contador]=(cantidad*precio_compra);
            total=total+subtotal[contador];
            var fila='<tr class="selected" id="fila'+contador+'"> '+
                        '<td><button type="button" class="btn btn-warning" onclick="eliminar('+contador+');">X</button> </td>'+
                        '<td><input type="hidden" name="idarticulo[]" value="'+idarticulo+'">'+articulo+'</input></td>'+
                        '<td><input type="number" name="cantidad[]" value="'+cantidad+'"></td>'+
                        '<td><input type="number" name="precio_compra[]" value="'+precio_compra+'"></td>'+
                        '<td>'+subtotal[contador]+'</td>'+
                    '</tr>';
            contador++;
            limpiar();
            $("#total").html("$ "+total);
            $("#total_ingreso").val(total);
            evaluar();
            $("#detalles").append(fila);
          }
          else{
            alert("Error al ingresar el detalle del ingreso.");
          }
      }

      function limpiar(){
        $("#pcantidad").val("");
        $("#pprecio_compra").val("");
       // $("#pprecio_venta").val("");
      }
      function evaluar(){
        if(total>0){
          $("#guardar").show();
        }else{
          $("#guardar").hide();
        }
      }
      function eliminar(index){
        total=total-subtotal[index];
        $("#total").html("$ "+total);
        $("#fila"+index).remove();
        evaluar();
      }

    </script>
  @endpush
@endsection
