<?php

namespace polleria\Http\Controllers;

use Illuminate\Http\Request;

use polleria\Http\Requests;
use polleria\Proveedor;
use Illuminate\Support\Facades\Redirect;
use polleria\Http\Requests\ProveedorFormRequest;
use DB;



class ProveedorController extends Controller
{
    //
    public function __construct(){

    }

    public function index(Request $request){
      if ($request) {
        $query= trim($request->get('searchText'));
        $personas=DB::table('proveedors')
        ->where('estado','=','activo')
        ->where('razonsocial','like','%'.$query.'%')
          //->where('cuit','like','%'.$query.'%')
        //  ->where('tipo_persona','=','proveedor')
          ->orderby('idproveedor','desc')
          ->paginate(9)
          ;
          return view('compras.proveedor.index',['personas'=>$personas,'searchText'=>$query]);
      }
    }
    public function create(){
      return view('compras.proveedor.create');
    }
    public function store(ProveedorFormRequest $request){
      $persona= new Proveedor;
     // $persona->tipo_persona = 'proveedor';
      $persona->razonsocial= $request->get('razonsocial');
     // $persona->tipo_documento= $request->get('tipo_documento');
      $persona->cuit= $request->get('cuit');
      $persona->direccion= $request->get('direccion');
      $persona->telefono= $request->get('telefono');
      $persona->email= $request->get('email');
      $persona->estado= "activo";
      $persona->save();
      return Redirect::to('compras/proveedor');

    }

    public function show($id){
      return view('compras.proveedor.show',['persona'=>Persona::findOrFail($id)]);
    }
    public function edit($id){
      return view('compras.proveedor.edit',['persona'=>Persona::findOrFail($id)]);

    }
    public function update(PersonaFormRequest $request, $id){
      $persona = Proveedor::findOrFail($id);
      $persona->razonsocial= $request->get('razonsocial');
    //  $persona->tipo_documento= $request->get('tipo_documento');
      $persona->cuit= $request->get('cuit');
      $persona->direccion= $request->get('direccion');
      $persona->telefono= $request->get('telefono');
      $persona->email= $request->get('email');
      $persona->save();
      return Redirect::to('compras/proveedor');
    }


    public function destroy($id){
      $persona = Proveedor::findOrFail($id);
      //dd($persona);
      $persona->estado="Inactivo";
      $persona->update();
      return Redirect::to('compras/proveedor');
    }
}
