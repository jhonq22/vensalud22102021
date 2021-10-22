<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
      protected $table = 'municipios';

     protected $fillable  = [
      'municipio',
      'estado_id'
    ];
}
