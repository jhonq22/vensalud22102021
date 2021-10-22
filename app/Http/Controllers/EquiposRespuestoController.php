<?php

namespace App\Http\Controllers;

use App\EquiposRespuesto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EquiposRespuestoController extends Controller
{
    public function index()
    {
        $equipos = DB::select("SELECT  equipos_repuestos.id, marca, equipo, nombre_repuesto, existencia, referencia, descripcion, equipos_repuestos.created_at, equipos_repuestos.updated_at
        FROM equipos_repuestos 
        LEFT JOIN marcas ON marca_id = marcas.id
        LEFT JOIN equipos ON equipo_id = equipos.id
      "
        );
        echo json_encode($equipos); // para pasar en json
    }
    

    
     public function store(Request $request)
    {
        $equipo = new EquiposRespuesto();
        $equipo->marca_id = $request->input('marca_id');
        $equipo->equipo_id = $request->input('equipo_id');
        $equipo->nombre_repuesto = $request->input('nombre_repuesto');
        $equipo->existencia = $request->input('existencia');
        $equipo->referencia = $request->input('referencia');
        $equipo->descripcion = $request->input('descripcion');
        
  
      

        $equipo->save(); // para guardar en json

        echo json_encode($equipo); // para pasar en json
    }

   

    public function show($equipo_id)
    {
        $equipos =EquiposRespuesto::find($equipo_id);
        echo json_encode($equipos);
    }
      

   
    public function update(Request $request, $equipo_id)
    {
        $equipo =EquiposRespuesto::find($equipo_id);
        $equipo->marca_id = $request->input('marca_id');
        $equipo->equipo_id = $request->input('equipo_id');
        $equipo->nombre_repuesto = $request->input('nombre_repuesto');
        $equipo->existencia = $request->input('existencia');
        $equipo->referencia = $request->input('referencia');
        $equipo->descripcion = $request->input('descripcion');
      
        $equipo->save(); // para guardar en json

        echo json_encode($equipo); // para pasar en json
    }

  
    public function destroy($equipo_id)
    {
        $equipo =EquiposRespuesto::find($equipo_id);
        $equipo->delete();
    }
}
