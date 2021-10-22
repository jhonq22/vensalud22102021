<?php

namespace App\Http\Controllers;

use App\HistoricoEstatu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoricoEstatuController extends Controller
{
    public function index()
    {
        $historicos =HistoricoEstatu::get();
        echo json_encode($historicos);
    }
    



    public function VerHistoricoEstatus($historico_id)
    {
         $inventarios = DB::select("SELECT historico_estatus.id, equipo, estatu_equipos.estatu_equipo, historico_estatus.observacion, users.name, centro_salud, historico_estatus.created_at
            FROM historico_estatus
            LEFT JOIN users ON historico_estatus.user_id = users.id
            LEFT JOIN centro_salud ON users.centro_salud_id = centro_salud.id
            LEFT JOIN inventarios ON inventario_id = inventarios.id
            LEFT JOIN estatu_equipos ON historico_estatus.estatu_equipo_id = estatu_equipos.id
            LEFT JOIN equipos ON inventarios.equipo_id = equipos.id
            WHERE inventario_id = ?", [$historico_id]);

        echo json_encode($inventarios); // para pasar en json

    }

    



    
     public function store(Request $request)
    {
        $historico = new HistoricoEstatu();
        $historico->inventario_id = $request->input('inventario_id');
        $historico->estatu_equipo_id = $request->input('estatu_equipo_id');
        $historico->observacion = $request->input('observacion');
        
  
      

        $historico->save(); // para guardar en json

        echo json_encode($historico); // para pasar en json
    }

   

    public function show($historico_id)
    {
        $historicos =HistoricoEstatu::find($historico_id);
        echo json_encode($historicos);
    }
      

   
    public function update(Request $request, $historico_id)
    {
        $historico =HistoricoEstatu::find($historico_id);
         $historico->inventario_id = $request->input('inventario_id');
        $historico->estatu_equipo_id = $request->input('estatu_equipo_id');
        $historico->observacion = $request->input('observacion');
      
        $historico->save(); // para guardar en json

        echo json_encode($historico); // para pasar en json
    }

  
    public function destroy($historico_id)
    {
        $historico =HistoricoEstatu::find($historico_id);
        $historico->delete();
    }
}
