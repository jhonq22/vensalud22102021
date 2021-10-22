<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
     protected $table = 'inventarios';

     protected $fillable  = [
      'estado_id',
      'municipio_id',
      'centro_salud_id',
      'servicio_medico',
      'piso',
      'equipo',
      'marca_id',
      'modelo',
      'serial',
      'numero_bien_nacional',
      'proveedor',
      'estatu_equipo_id',
      'observacion',
      'reparado',
      'fecha_instalacion',
      'proveedor_servicio',
      'user_id'
         
  ];
}
