<?php

namespace App\Http\Controllers;

use App\Ente;
use Illuminate\Http\Request;

class EnteController extends Controller
{
     public function index()
    {
        $entes =Ente::get();
        echo json_encode($entes);
    }
    

    
     public function store(Request $request)
    {
        $ente = new Ente();
        $ente->ente = $request->input('ente');
  
      

        $ente->save(); // para guardar en json

        echo json_encode($ente); // para pasar en json
    }

   

    public function show($ente_id)
    {
        $entes =Ente::find($ente_id);
        echo json_encode($entes);
    }
      

   
    public function update(Request $request, $ente_id)
    {
        $ente =Ente::find($ente_id);
         $ente->ente = $request->input('ente');
      
        $ente->save(); // para guardar en json

        echo json_encode($ente); // para pasar en json
    }

  
    public function destroy($ente_id)
    {
        $ente =Ente::find($ente_id);
        $ente->delete();
    }
}
