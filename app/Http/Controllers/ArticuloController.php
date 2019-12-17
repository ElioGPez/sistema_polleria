<?php

namespace polleria\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input; //para subir la imagen al servidor
use polleria\Http\Requests;
use polleria\Http\Requests\ArticuloFormRequest;
use polleria\Articulo;
use DB;

class ArticuloController extends Controller
{
    //
    public function __construct(){
      $this->middleware('auth');
    }

    public function index(Request $request){
      if ($request) {
        $query= trim($request->get('searchText'));
        $articulos=DB::table('articulos as a')
          ->join('categorias as c','a.idcategoria','=','c.idcategoria')
          ->select('a.idarticulo','a.nombre','a.codigo','a.stock','c.nombre as categoria','a.precio_venta','a.descripcion','a.imagen','a.estado')
          ->where('estado','=','activo')
         // ->where('a.nombre','like','%'.$query.'%')
          ->where('a.codigo','like','%'.$query.'%')
          ->orderby('a.idarticulo','desc')
          ->paginate(9)
          ;
        return view('almacen.articulo.index',['articulos'=>$articulos,'searchText'=>$query]);
      }
    }

    public function create(){
      $categorias = DB::table('categorias')->where('condicion','=','1')->get();
      return view('almacen.articulo.create',['categorias'=>$categorias]);
    }

    public function store(ArticuloFormRequest $request){
    //  dd($request);
      $articulo = new Articulo;
      $articulo->idcategoria=$request->get('idcategoria');
      $articulo->codigo=$request->get('codigo');
      $articulo->nombre=$request->get('nombre');
      $articulo->stock=$request->get('stock');
      $articulo->descripcion=$request->get('descripcion');
      $articulo->precio_venta=$request->get('precio_venta');

      $articulo->estado="Activo";
      if (Input::hasFile('imagen')) {
        $file=Input::file('imagen');
        $file->move(public_path().'/imagenes/articulos',$file->getClientOriginalName());
        $articulo->imagen=$file->getClientOriginalName();
      }
      $articulo->save();
      return Redirect::to('almacen/articulo');

    }

    public function show($id){
      return view('almacen.articulo.show',['articulo'=>Articulo::findOrFail($id)]);
    }
 
    public function edit($id){
      $articulo=Articulo::findOrFail($id);
      $categorias=DB::table('categorias')->where('condicion','=','1')->get();
      return view('almacen.articulo.edit',['articulo'=>$articulo,'categorias'=>$categorias]);

    }
    public function update(ArticuloFormRequest $request, $id){
      $articulo = Articulo::findOrFail($id);
      $articulo->idcategoria=$request->get('idcategoria');
      $articulo->codigo=$request->get('codigo');
      $articulo->nombre=$request->get('nombre');
      $articulo->stock=$request->get('stock');
      $articulo->descripcion=$request->get('descripcion');
      $articulo->estado= $request->get('estado');
      $articulo->precio_venta=$request->get('precio_venta');

      if (Input::hasFile('imagen')) {
        $file=Input::file('imagen');
        $file->move(public_path().'/imagenes/articulos',$file->getClientOriginalName());
        $articulo->imagen=$file->getClientOriginalName();
      }
      $articulo->update();
      return Redirect::to('almacen/articulo');
    }

    public function destroy($id){
      $articulo = Articulo::findOrFail($id);
      $articulo->estado = 'Inactivo';
      $articulo->update();
      return Redirect::to('almacen/articulo');
    }





}
