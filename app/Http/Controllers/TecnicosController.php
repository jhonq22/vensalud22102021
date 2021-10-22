<?php

namespace App\Http\Controllers;

use App\Tecnicos;
use Illuminate\Http\Request;

class TecnicosController extends Controller
{
    public function index()
    {
        $tecnicos =Tecnicos::get();
        echo json_encode($tecnicos);
    }
    

    
     public function store(Request $request)
    {
        $tecnico = new Tecnicos();
        $tecnico->cedula = $request->input('cedula');
        $tecnico->nombres = $request->input('nombres');
        $tecnico->apellidos = $request->input('apellidos');
        
  
      

        $tecnico->save(); // para guardar en json

        echo json_encode($tecnico); // para pasar en json
    }

   

    public function show($tecnico_id)
    {
        $tecnicos =Tecnicos::find($tecnico_id);
        echo json_encode($tecnicos);
    }
      

   
    public function update(Request $request, $tecnico_id)
    {
        $tecnico =Tecnicos::find($tecnico_id);
        $tecnico->cedula = $request->input('cedula');
        $tecnico->nombres = $request->input('nombres');
        $tecnico->apellidos = $request->input('apellidos');
      
        $tecnico->save(); // para guardar en json

        echo json_encode($tecnico); // para pasar en json
    }

  
    public function destroy($tecnico_id)
    {
        $tecnico =Tecnicos::find($tecnico_id);
        $tecnico->delete();
    }
}
