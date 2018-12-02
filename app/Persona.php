<?php

namespace polleria;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    //
    protected $table      = "persona";
    protected $primaryKey = "idpersona";

    protected $filable = [
        'tipo_persona',
        'nombre',
        'tipo_documento',
        'num_documento',
        'direccion',
        'telefono',
        'email',
    ];

}
