<?php

namespace polleria;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    //
    protected $table= "clientes";
    protected $primaryKey ="idcliente";

    protected $filable = [
      'nombre',
      'documento',
      'direccion',
      'telefono',
      'email',
      'estado'
    ]; 
    public function cuenta()
    {
        return $this->hasOne('polleria\Cuenta');
    }
}
