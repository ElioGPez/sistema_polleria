@extends('layouts.admin')
@section('contenido')


    <div class="container col-lg-8 col-md-8 col-sm-8 col-xs-8">
        <div class="row" style="font-size: 20px;padding-left: 20px; border-style: solid;border-width: thin;">
            <div  class="form-group" align="center">
               <h3 for="cliente"><b>Información del Cliente</b></h3>
            </div>
            <div class="form-group">
                <p for="cliente"><b>Cliente:</b> {{$cuenta->cliente->nombre}}</p>
            </div>    
            <div class="form-group">
                <p for="cliente"><b>DNI:</b> {{$cuenta->cliente->documento}}</p>
            </div>   
            <div class="form-group">
                <p for="cliente"><b>Saldo:</b> <b style="color: red;">${{$cuenta->saldo}}</b></p>
            </div>      
        </div>
    </div>
    <div class="container col-lg-3 col-md-4 col-sm-4 col-xs-4"" style="margin-left: 20px; border-style: solid;border-width: thin;">
        <div class="row" style="font-size: 20px;padding-left: 20px; padding-right: 20px;">
            <div  class="form-group" align="center">
               <h3 for="cliente"><b>Agregar PAGO</b></h3>
            </div>
            <div  class="form-group" align="center">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input id="pago" name="pago" type="number" class="form-control"  placeholder="$0.00">
            </div>
            <div  class="form-group" align="center">
                <button type="submit" id="btnPago" class="btn btn-primary">REGISTRAR</button>
            </div>
        </div>
    </div>

          <div class="col-lg-6 col-sm-12 col-md-6 col-xs-12">
            <div class="form-group">
            <h3 align="center">Compras realizadas</h3>
            </div>
            <table class="table table-striped table-bordered table-condensed table-hover">
              <thead style="background-color:#A9D0F5">
                <th style="display: none">ID</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Total</th>
              </thead>
              <tfoot>

                <th></th>
                <th></th>
                <th></th>
                <th></th>
              </tfoot>
              <tbody>
                @foreach ($ventas as $venta)
                  <tr>
                    <td style="display: none">{{$venta->idventa}}</td>
                    <td>{{$venta->fecha}}</td>
                    <td>{{$venta->estado}}</td>
                    <td>{{$venta->total_venta}}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>


          <div class="col-lg-6 col-sm-12 col-md-6 col-xs-12">
            <div class="form-group">
            <h3 align="center">Pagos realizados</h3>
            </div>
            <table class="table table-striped table-bordered table-condensed table-hover" id="detalles">
              <thead style="background-color:#A9D0F5">
                <th style="display: none">ID</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Total</th>
              </thead>
              <tfoot>
 
                <th></th>
                <th></th>
                <th></th>
                <th></th>
              </tfoot>
              <tbody>
                @foreach ($pagos as $pago)
                  <tr>
                    <td style="display: none">{{$pago->idpago}}</td>
                    <td>{{$pago->fecha}}</td>
                    <td>{{$pago->estado}}</td>
                    <td>{{$pago->monto}}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

    <div class="row">
 


    </div>

@push('scripts')
    <script>
      $(document).ready(function(){

        $('#btnPago').click(function(){
          agregar();
        })

      //document.getElementById("acuenta").che = true;  
          // $("#acuenta").attr("checked","checked");
      });
 
      total =0;
      var contador=0;
      subtotal=[];

      

      function agregar(){
       var token = $("input[name='_token']").val();
          pago=$("#pago").val();
        if (parseFloat(pago)>0) {

        $.ajax({

        type: "post",
        url: " {{ route('cuenta.ajax') }}",
        data: {
            "_token": token,
            monto: pago,
            idcuenta: "{{$cuenta->idcuenta}}"
        }, success: function (msg) {
          if($.isEmptyObject(msg.error)){
        //                    alert("Se ha realizado el POST con exito ");

        var dt = new Date();
        var mes = dt.getMonth()+1;
        var dia = dt.getDate();
        var año = dt.getFullYear();
        var fechaActual = año + '-' + mes + '-' + dia;

              var fila='<tr class="selected" id="fila"> '+

                          '<td style="display: none" name="idpago[]" value="">0</td>'+
                          '<td name="fecha[]" value="">'+fechaActual+'</td>'+
                          '<td name="estado[]" value="">A</td>'+
                          '<td name="monto[]" value="">'+pago+'</td>'+
                        //  '<td>'+subtotal[contador]+'</td>'+
                      '</tr>';
      $.each(msg,function(index,el){
      //  alert(el.monto);
      });
              contador++;
              limpiar();

              $("#detalles").append(fila);
        }else{
                          alert("Se ha realizado el POST con error ");

        }
        }
      });
            }else{
              alert('La cantidad ingresada debe ser mayor que $0');
            }
      }

      function limpiar(){
        $("#pago").val("");
      }


    </script>
  @endpush
@endsection
