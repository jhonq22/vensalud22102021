<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoricoEstatu extends Model
{
      protected $table = 'historico_estatus';

     protected $fillable  = [
      'inventario_id',
      'estatu_equipo_id',
      'observacion'
         
  ];
}
