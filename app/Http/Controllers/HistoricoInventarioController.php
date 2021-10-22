<?php

namespace App\Http\Controllers;

use App\HistoricoInventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoricoInventarioController extends Controller
{
    
    public function index()
    {
        $inventarios = DB::select("
        SELECT equipo, marca, inventarios.serial, centro_salud.centro_salud, estado, users.name, historico_inventarios.created_at, historico_inventarios.updated_at
        FROM historico_inventarios
        LEFT JOIN users ON user_id = users.id
        LEFT JOIN inventarios ON inventario_id = inventarios.id
        LEFT JOIN equipos ON inventarios.equipo_id = equipos.id
        LEFT JOIN marcas ON inventarios.marca_id = marcas.id
        LEFT JOIN estados ON inventarios.estado_id = estados.id
        LEFT JOIN centro_salud ON inventarios.centro_salud_id = centro_salud.id
        ");

    echo json_encode($inventarios); // para pasar en json
    }

    
    public function create()
    {
       
    }

    
    public function store(Request $request)
    {
        $historico = new HistoricoInventario();
        $historico->inventario_id = $request->input('inventario_id');
        $historico->user_id = $request->input('user_id');
   
        $historico->save(); // para guardar en json

        echo json_encode($historico); // para pasar en json
    }

   
    public function show(HistoricoInventario $historicoInventario)
    {
        //
    }

   
    public function edit(HistoricoInventario $historicoInventario)
    {
        //
    }

   
    public function update(Request $request, HistoricoInventario $historicoInventario)
    {
        //
    }

   
    public function destroy(HistoricoInventario $historicoInventario)
    {
        //
    }
}
