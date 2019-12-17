<?php

namespace polleria\Http\Controllers;

use Illuminate\Http\Request;

use polleria\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use polleria\Http\Requests\VentaForRequest;
use polleria\Venta;
use polleria\Cuenta;
use polleria\DetalleVenta;
use polleria\Articulo;
use DB;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;


class VentaController extends Controller
{
    //
    public function __construct(){
      $this->middleware('auth');
    } 

    public function index(Request $request){
      if ($request) {
        $query = trim($request->get('searchText'));
        $ventas=DB::table('ventas as v')
        //->join('cuenta_venta as cv','v.idventa','=','cv.idventa')
     //   ->join('cuentas as c','cv.idcuenta','=','c.idcuenta')
      //  ->join('clientes as cl','c.idcliente','=','cl.idcliente')
        ->join('detalle_venta as dv','v.idventa','=','dv.idventa')
        ->select('v.idventa','v.fecha',//'cl.nombre',
          'v.estado','v.total_venta')
        ->where('v.idventa','LIKE',"%".$query."%")
        ->orderBy('v.idventa','DESC')
        ->groupBy('v.idventa','v.fecha','v.estado')
         ->paginate(9);
        // dd($ventas);
        return view('ventas.venta.index',['ventas'=>$ventas,'searchText'=>$query]);
      }
    }

    public function create(){ 
      $personas=DB::table('clientes')->where('estado','=','activo')->get();
      $articulos=DB::table('articulos as art')
      //->join('detalle_ingreso as di','art.idarticulo','=','di.idarticulo')
      // ->select(DB::raw('CONCAT(art.codigo, " ", art.nombre) as articulo'), 'art.idarticulo','art.stock',DB::raw('avg(di.precio_venta)  as precio_promedio'))
      ->select(DB::raw('CONCAT(art.codigo, " ", art.nombre) as articulo'), 'art.idarticulo','art.stock','art.precio_venta as precio_promedio')
      ->where('art.estado','=','activo')
      ->where('art.stock','>',"0")
      ->groupBy('articulo','art.idarticulo','art.stock')
      ->get();
      //dd($articulos);
      return view('ventas.venta.create',['personas'=>$personas,'articulos'=>$articulos]);
    }
 
    public function store(VentaForRequest $request){
      //dd($request);
      try {
        DB::beginTransaction();
        $venta=new Venta;
       // $venta->idcliente = $request->get('idcliente');
     //   $venta->tipo_comprobante=$request->get('tipo_comprobante');
     //   $venta->serie_comprobante=$request->get('serie_comprobante');
     //   $venta->num_comprobante=$request->get('num_comprobante');
        $venta->total_venta=$request->get('total_venta');
 
        $mytime= Carbon::now('America/Argentina/Tucuman');
        $venta->fecha = $mytime->toDateTimeString();
      //  $venta->impuesto='18';
        $venta->estado='A'; //A de activo
       // dd( $venta->total_venta);

        $venta->save();
        if($request->seleccionado == 1){
        $cuentaDB=DB::table('cuentas')->where('idcliente','=',$request->idcliente)->get();
        $cuenta= Cuenta::findOrfail($cuentaDB[0]->idcuenta);
        $cuenta->saldo = $cuenta->saldo + $venta->total_venta;
        $cuenta->save();

        DB::table('cuenta_venta')->insert(
          ['idventa' => $venta->idventa, 'idcuenta' => $cuenta->idcuenta]
        );
        }


        $idarticulo = $request->get('idarticulo');
        $cantidad = $request->get('cantidad');
        $descuento = $request->get('descuento');
        $precio_venta=$request->get('precio_venta');


        $cont = 0;
        while ($cont < count($idarticulo) ) {


          $detalle=new DetalleVenta();
          $detalle->idventa=$venta->idventa;
          $detalle->idarticulo=$idarticulo[$cont];
          $detalle->cantidad=$cantidad[$cont];
          $detalle->descuento=$descuento[$cont];
          $detalle->precio_venta=$precio_venta[$cont];
          $detalle->save();
          $cont=$cont+1;
        }
        $cont=0;
        while($cont<count($idarticulo)){
          $articulo= Articulo::findOrfail($idarticulo[$cont]);
          $articulo->stock = $articulo->stock - $cantidad[$cont];
          $articulo->save();
          $cont=$cont+1;
        }
        DB::commit();
      } catch (\Exception $ex) {
        DB::rollback();
      }
      return Redirect::to('ventas/venta');
    } 

    public function show($id){

      $venta=DB::table('ventas as v')
      //->join('cuenta_venta as cv','v.idventa','=','cv.idventa')
     // ->join('cuentas as c','cv.idcuenta','=','c.idcuenta')
   //   ->join('clientes as p','c.idcliente','=','p.idcliente')
      ->join('detalle_venta as dv','v.idventa','=','dv.idventa')
      ->select('v.idventa','v.fecha','v.estado','v.total_venta')
      ->where('v.idventa','=',$id)
        ->first();        
      //dd($venta);

      $detalles=DB::table('detalle_venta as d')
      ->join('articulos as a','d.idarticulo','=','a.idarticulo')
      ->select('a.nombre as articulo','d.cantidad','d.descuento','d.precio_venta')
      ->where('d.idventa','=',$id)
      ->get();
      return view('ventas.venta.show',['venta'=>$venta,'detalles'=>$detalles]);
    }

    public function destroy($id){
      $venta=Venta::findOrFail($id);
      $venta->estado='C';
      $venta->update();
      return Redirect::to('ventas/venta');
    }

}
