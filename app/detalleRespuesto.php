<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class detalleRespuesto extends Model
{
    protected $table = 'detalle_requirimientos';

    protected $fillable  = [
     'repuesto_id',
     'cantidad_pedido',
     'fecha_solicitud',
     'user_id',
     'estatu_solicitud_repuesto_id'
          
   ];

}
