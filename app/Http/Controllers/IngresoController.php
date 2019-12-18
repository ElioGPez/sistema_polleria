<?php

namespace polleria\Http\Controllers;

use Illuminate\Http\Request;

use polleria\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use polleria\Http\Requests\IngresoFormRequest;
use polleria\Ingreso;
use polleria\Articulo;
use polleria\DetalleIngreso;
use DB;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

class IngresoController extends Controller
{
    //
    public function __construct(){

    }
  
    public function index(Request $request){
      if ($request) {
        $query = trim($request->get('searchText'));
        $ingresos=DB::table('ingresos as i')
        ->join('proveedors as p','i.idproveedor','=','p.idproveedor')
        ->join('detalle_ingreso as di','i.idingreso','=','di.idingreso')
        ->select('i.idingreso','p.razonsocial','i.fecha','i.estado', DB::raw('sum(di.cantidad*precio_compra) as total'))
        ->where('i.idingreso','LIKE',"%".$query."%")
        ->orderBy('i.idingreso','DESC')
        ->groupBy('i.idingreso','i.fecha','p.razonsocial','i.estado')
        ->paginate(9);
        //dd($ingresos);
        return view('compras.ingreso.index',['ingresos'=>$ingresos,'searchText'=>$query]);
      }
    }
 
    public function create(){
      $personas=DB::table('proveedors')->where('estado','=','activo')->get(); 
      $articulos=DB::table('articulos as art')
      ->select(DB::raw('CONCAT(art.codigo, " ", art.nombre) as articulo'), 'art.idarticulo')
      ->where('art.estado','=','activo')
      ->get();
      return view('compras.ingreso.create',['personas'=>$personas,'articulos'=>$articulos]);
    }
 
    public function store(IngresoFormRequest $request){
      try {
        DB::beginTransaction();
        $ingreso = new Ingreso;
        $ingreso->idproveedor = $request->get('idproveedor');
       // $ingreso->tipo_comprobante=$request->get('tipo_comprobante');
       // $ingreso->serie_comprobante=$request->get('serie_comprobante');
       // $ingreso->num_comprobante=$request->get('num_comprobante');
        $mytime= Carbon::now('America/Argentina/Tucuman');
        $ingreso->fecha = $mytime->toDateTimeString();
        $ingreso->total_ingreso=$request->get('total_ingreso');
        $ingreso->estado='A'; //A de activo
        $ingreso->save(); 

        $idarticulo = $request->get('idarticulo');
        $cantidad = $request->get('cantidad');
        $precio_compra = $request->get('precio_compra');
        //$precio_venta=$request->get('precio_venta');
 
        $cont = 0;
        while ($cont < count($idarticulo) ) {
          $detalle=new DetalleIngreso();
          $detalle->idingreso=$ingreso->idingreso;
          $detalle->idarticulo=$idarticulo[$cont];
          $detalle->cantidad=$cantidad[$cont];
          $detalle->precio_compra=$precio_compra[$cont];
          //$detalle->precio_venta=$precio_venta[$cont];
          //Actualizamos el stock del articulo i
          $articulo= Articulo::findOrfail($idarticulo[$cont]);
          //dd($articulo->stock);
          $articulo->stock += $cantidad[$cont];
          $articulo->save();

          $detalle->save();
          $cont=$cont+1;
        }
        DB::commit();
      } catch (\Exception $e) {
        DB::rollback();
      }
      return Redirect::to('compras/ingreso');
    }

    public function show($id){
      $ingreso=DB::table('ingresos as i')
      ->join('proveedors as p','i.idproveedor','=','p.idproveedor')
      ->join('detalle_ingreso as di','i.idingreso','=','di.idingreso')
      ->select('i.idingreso','i.fecha','p.razonsocial','i.estado', DB::raw('sum(di.cantidad*precio_compra) as total'))
      ->where('i.idingreso','=',$id)
      ->first();

      $detalles=DB::table('detalle_ingreso as d')
      ->join('articulos as a','d.idarticulo','=','a.idarticulo')
      ->select('a.nombre as articulo','d.cantidad','d.precio_compra')
      ->where('d.idingreso','=',$id)
      ->get();
 
      return view('compras.ingreso.show',['ingreso'=>$ingreso,'detalles'=>$detalles]);
    }

    public function destroy($id){
      $ingreso=Ingreso::findOrFail($id);
      $ingreso->estado='C';
      $ingreso->update();
      return Redirect::to('compras/ingreso');
    }














}
