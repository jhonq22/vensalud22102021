<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MultimediaInventario extends Model
{
      protected $table = 'multimedia_inventarios';

     protected $fillable  = [
      'imagen',
      'nombre_archivo',
      'inventario_id'
    ];
}
