<?php

namespace polleria\Http\Controllers;

use Illuminate\Http\Request;

use polleria\Http\Requests;
use DB;
use polleria\Cuenta;
use polleria\Cliente;
use polleria\Pago;
use Carbon\Carbon;


class CuentaController extends Controller
{
    //
    public function __construct(){

    }

    public function index(Request $request){

    }

    public function create(){

    }

    public function store(Request $request){


    } 

    public function show($id){
      $cuentaDB=DB::table('cuentas')->where('idcliente','=',$id)->get();
      $cuenta= Cuenta::findOrfail($cuentaDB[0]->idcuenta);
      $cliente= Cliente::findOrfail($id);
      $cuenta->cliente = $cliente;

      $ventas =DB::table('ventas as v')
      ->join('cuenta_venta as cv','v.idventa','=','cv.idventa')
      ->join('cuentas as c','cv.idcuenta','=','c.idcuenta')
      ->select('v.idventa','v.fecha','v.estado','v.total_venta')
      ->where('c.idcuenta','=',$cuenta->idcuenta)
      ->get();
      $pagos =DB::table('pagos as p')
      ->select('p.idpago','p.fecha','p.estado','p.monto')
      ->where('p.idcuenta','=',$cuenta->idcuenta)
      ->get();
      //dd($pagos);
      //dd($ventas);
      //dd($cuenta);
      return view('ventas.cliente.cuenta.show',['cuenta'=>$cuenta,'ventas'=>$ventas,'pagos'=>$pagos]);
    } 
    public function ajax(Request $request){
         $Pago = new Pago();
         $Pago->monto = $request->monto;
         $Pago->idcuenta = $request->idcuenta;
         $mytime= Carbon::now('America/Argentina/Tucuman');
         $Pago->fecha = $mytime->toDateTimeString();
         $Pago->estado = "A";
         $Pago->save();

     // dd($saldo);
      $cuenta=DB::table('cuentas')->where('idcuenta','=',$request->idcuenta)->get();

      $saldo =  $cuenta[0]->saldo - $request->monto;

      DB::table('cuentas as c')
      ->where('c.idcuenta','=',$request->idcuenta)
      ->update(['c.saldo' => $saldo]);

      return Response()->json($Pago);
 
    }

    public function edit($id){


    }
    public function update(PersonaFormRequest $request, $id){

    }


    public function destroy($id){

    }
}
