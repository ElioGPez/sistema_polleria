<?php 
namespace polleria;

use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{

  protected $table= "cuentas";
  protected $primaryKey ="idcuenta";
 
  protected $filable = [
  'idcliente',
  'saldo',
  //'idventa'
  ];
    public function cliente()
    {
        return $this->belongsTo('polleria\Cliente');
    }
    public function venta()
    {

        return $this->belongsToMany('polleria\Venta');
    }
} 