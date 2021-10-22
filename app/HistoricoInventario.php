<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoricoInventario extends Model
{
    protected $table = 'historico_inventarios';

    protected $fillable  = [
     'inventario_id',
     'user_id',
            
 ];
}



