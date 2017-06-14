<?php

namespace polleria\Http\Controllers;

use Illuminate\Http\Request;

use polleria\Http\Requests;
use polleria\Persona;
use Illuminate\Support\Facades\Redirect;
use polleria\Http\Requests\PersonaFormRequest;
use DB;



class ProveedorController extends Controller
{
    //
    public function __constructor(){

    }

    public function index(Request $request){
      if ($request) {
        $query= trim($request->get('searchText'));
        $personas=DB::table('persona')
          ->where('nombre','like','%'.$query.'%')
          ->where('tipo_persona','=','proveedor')
          ->orwhere('num_documento','like','%'.$query.'%')
          ->where('tipo_persona','=','proveedor')
          ->orderby('idpersona','desc')
          ->paginate(9)
          ;
          return view('compras.proveedor.index',['personas'=>$personas,'searchText'=>$query]);
      }
    }
    public function create(){
      return view('compras.proveedor.create');
    }
    public function store(PersonaFormRequest $request){
      $persona= new Persona;
      $persona->tipo_persona = 'proveedor';
      $persona->nombre= $request->get('nombre');
      $persona->tipo_documento= $request->get('tipo_documento');
      $persona->num_documento= $request->get('num_documento');
      $persona->direccion= $request->get('direccion');
      $persona->telefono= $request->get('telefono');
      $persona->email= $request->get('email');
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
      $persona = Persona::findOrFail($id);
      $persona->nombre= $request->get('nombre');
      $persona->tipo_documento= $request->get('tipo_documento');
      $persona->num_documento= $request->get('num_documento');
      $persona->direccion= $request->get('direccion');
      $persona->telefono= $request->get('telefono');
      $persona->email= $request->get('email');
      $persona->save();
      return Redirect::to('compras/proveedor');
    }


    public function destroy($id){
      $persona = Persona::findOrFail($id);
      $persona->tipo_persona="Inactivo";
      $persona->update();
      return Redirect::to('compras/proveedor');
    }
}
