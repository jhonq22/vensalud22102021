<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BibliotecaVirtual extends Model
{
    protected $table = 'bibloteca_virtual';

     protected $fillable  = [
      'tipo_bibloteca',
      'equipo',
      'marca',
      'modelo',
      'url_archivo',
      'descripcion'
            
    ];
}
