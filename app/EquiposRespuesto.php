<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EquiposRespuesto extends Model
{
    protected $table = 'equipos_repuestos';

     protected $fillable  = [
      'marca_id',
      'equipo_id',
      'nombre_repuesto',
      'existencia',
      'referencia',
      'descripcion'
      
    ];
}
