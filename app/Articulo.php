<?php

namespace polleria;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{

  protected $table= "articulos";
  protected $primaryKey ="idarticulo";
 
  protected $filable = [
  'idcategoria',
  'codigo',
  'nombre',
  'stock',
  'descripcion',
  'imagen',
  'estado',
  'precio_venta'
  ];

    public function categoria()
    {
        return $this->belongsTo('App\Articulo');
    }
    public function detalleVenta()
    {
        return $this->belongsTo('App\DetalleVenta');
    }
    public function detalleIngreso()
    {
        return $this->belongsTo('App\DetalleIngreso');
    }
}
