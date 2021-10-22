<?php

namespace App\Imports;

use App\Inventario;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class InventarioImport implements ToModel, WithStartRow
{
    
    public function model(array $row)
    {
        return new Inventario([
            'servicio_medico'     => $row[0],
            'piso'    => $row[1],
            'equipo'  => $row[2],
            'modelo'  => $row[3],
            'serial'  => $row[4],
            'numero_bien_nacional'    => $row[5],
            'proveedor'    => $row[6],
            'observacion'    => $row[7],
            'reparado'    => $row[8],
            'proveedor_servicio'    => $row[9],
            'marca_id'    => $row[10],
            'estatu_equipo_id'    => $row[11],

            'estado_id' => request()->get('estado_id'),
            'municipio_id' => request()->get('municipio_id'),
            'centro_salud_id' => request()->get('centro_salud_id'),
            //'marca_id' => request()->get('marca_id'),
            //'estatu_equipo_id' => request()->get('estatu_equipo_id'),
            'user_id' => request()->get('user_id'),
          
     
        ]);
    }


     public function startRow(): int
    {
        return 2;
    }
}


