<?php

namespace App\Http\Controllers;

use App\CentroSalud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CentroSaludController extends Controller
{
    public function index()
    {
        $saluds =CentroSalud::orderBy('centro_salud', 'asc')->get();;
        echo json_encode($saluds);
    }


    public function centroRegistrada($centro)
    {
        $centros = DB::select("SELECT * 
        FROM centro_salud
        WHERE centro_salud = ?", [$centro]);

        echo json_encode($centros); // para pasar en json
    }



     public function centrosaludList()
    {
        $centro_salud = DB::select("
        SELECT centro_salud.id, centro_salud, estado, municipio,direccion,tipo,contacto_tlf,contacto_email, 
        centro_salud.created_at, centro_salud.updated_at
        FROM centro_salud
        LEFT JOIN estados ON estado_id = estados.id
        LEFT JOIN municipios ON municipio_id = municipios.id
        ORDER BY centro_salud.id DESC");

        echo json_encode($centro_salud); // para pasar en json
    }


    public function centrosaludListEstados($estado_id)
    {
        $centro_salud = DB::select("SELECT centro_salud.id, centro_salud, estado, municipio,direccion,tipo,contacto_tlf,contacto_email, 
        centro_salud.created_at, centro_salud.updated_at
        FROM centro_salud
        LEFT JOIN estados ON estado_id = estados.id
        LEFT JOIN municipios ON municipio_id = municipios.id
        WHERE centro_salud.estado_id = ?
        ORDER BY centro_salud.id DESC", [$estado_id]);

        echo json_encode($centro_salud); // para pasar en json
    }
    
    

    
     public function store(Request $request)
    {
        $salud = new CentroSalud();
        $salud->centro_salud = $request->input('centro_salud');
        $salud->tipo = $request->input('tipo');
        $salud->estado_id = $request->input('estado_id');
        $salud->municipio_id = $request->input('municipio_id');
        $salud->direccion = $request->input('direccion');
       // $salud->rif = $request->input('rif');
        $salud->contacto_tlf = $request->input('contacto_tlf');
        $salud->contacto_email = $request->input('contacto_email');

  
      

        $salud->save(); // para guardar en json

        echo json_encode($salud); // para pasar en json
    }

   

    public function show($salud_id)
    {
        $saluds =CentroSalud::find($salud_id);
        echo json_encode($saluds);
    }
      

   
    public function update(Request $request, $salud_id)
    {
        $salud =CentroSalud::find($salud_id);
        $salud->centro_salud = $request->input('centro_salud');
        $salud->tipo = $request->input('tipo');
        $salud->estado_id = $request->input('estado_id');
        $salud->municipio_id = $request->input('municipio_id');
        $salud->direccion = $request->input('direccion');
       // $salud->rif = $request->input('rif');
        $salud->contacto_tlf = $request->input('contacto_tlf');
        $salud->contacto_email = $request->input('contacto_email');

      
        $salud->save(); // para guardar en json

        echo json_encode($salud); // para pasar en json
    }

  
    public function destroy($salud_id)
    {
        $salud =CentroSalud::find($salud_id);
        $salud->delete();
    }
}
