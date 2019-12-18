<?php

namespace polleria\Http\Controllers;

use Illuminate\Http\Request;

use polleria\Http\Requests;
use polleria\Cliente;
use polleria\Cuenta;
use Illuminate\Support\Facades\Redirect;
use polleria\Http\Requests\ClienteFormRequest;
use DB;

class ClienteController extends Controller
{
    //
    public function __construct(){

    }

    public function index(Request $request){
      if ($request) {
        $query= trim($request->get('searchText'));
        $clientes=DB::table('clientes')
          ->where('estado','=','activo')
          ->where('nombre','like','%'.$query.'%')
          //->orwhere('documento','like','%'.$query.'%')
          //->where('tipo_persona','=','cliente')
          ->orderby('idcliente','desc')
          ->paginate(9)
          ;
          return view('ventas.cliente.index',['clientes'=>$clientes,'searchText'=>$query]);
      }
    }
    public function create(){
      return view('ventas.cliente.create');
    }
    public function store(ClienteFormRequest $request){
      $persona= new Cliente;
     // $persona->tipo_persona = 'cliente';
      $persona->nombre= $request->get('nombre');
      //$persona->tipo_documento= $request->get('tipo_documento');
      $persona->documento= $request->get('documento');
      $persona->direccion= $request->get('direccion');
      $persona->telefono= $request->get('telefono');
      $persona->email= $request->get('email');
      $persona->estado= "activo";
      $persona->save();

      $cuenta = new Cuenta;
      $cuenta->saldo= 0;
      $cuenta->idcliente= $persona->idcliente;
      $cuenta->save();

      //$persona->cuenta()->attach($cuenta);

      return Redirect::to('ventas/cliente');

    }

    public function show($id){
      return view('ventas.cliente.show',['persona'=>Cliente::findOrFail($id)]);
    }
    public function edit($id){
      return view('ventas.cliente.edit',['cliente'=>Cliente::findOrFail($id)]);

    }
    public function update(ClienteFormRequest $request, $id){
      if ($request) {
      //      dd($request);

      $persona = Cliente::findOrFail($id);
      $persona->nombre= $request->get('nombre');
      $persona->documento= $request->get('documento');
      $persona->direccion= $request->get('direccion');
      $persona->telefono= $request->get('telefono');
      $persona->email= $request->get('email');
      $persona->save();
      return Redirect::to('ventas/cliente');
      }
    }


    public function destroy($id){
      $persona = Cliente::findOrFail($id);
      $persona->estado="Inactivo";
      $persona->update();
      return Redirect::to('ventas/cliente');
    }

}
