<?php

namespace App\Http\Controllers;

use App\EstatuEquipo;
use Illuminate\Http\Request;

class EstatuEquipoController extends Controller
{
     public function index()
    {
        $estatus =EstatuEquipo::get();
        echo json_encode($estatus);
    }
    

    
     public function store(Request $request)
    {
        $estatu = new EstatuEquipo();
        $estatu->estatu_equipo = $request->input('estatu_equipo');
  
      

        $estatu->save(); // para guardar en json

        echo json_encode($estatu); // para pasar en json
    }

   

    public function show($estatu_id)
    {
        $estatus =EstatuEquipo::find($estatu_id);
        echo json_encode($estatus);
    }
      

   
    public function update(Request $request, $estatu_id)
    {
        $estatu =EstatuEquipo::find($estatu_id);
         $estatu->estatu_equipo = $request->input('estatu_equipo');
      
        $estatu->save(); // para guardar en json

        echo json_encode($estatu); // para pasar en json
    }

  
    public function destroy($estatu_id)
    {
        $estatu =EstatuEquipo::find($estatu_id);
        $estatu->delete();
    }
}
