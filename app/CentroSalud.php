<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CentroSalud extends Model
{
     protected $table = 'centro_salud';

     protected $fillable  = [
      'centro_salud',
      'tipo_hospital',
      'estado_id',
      'municipio_id',
      'direccion',
      'rif',
      'contacto_tlf',
      'contacto_email',
    ];
}
