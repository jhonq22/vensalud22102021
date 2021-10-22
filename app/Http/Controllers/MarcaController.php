<?php

namespace App\Http\Controllers;

use App\Marca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarcaController extends Controller
{
     public function index()
    {
        $marcas =Marca::get();
        echo json_encode($marcas);
    }
    

    
    public function marcasRegistrada($marca)
    {
        $marcas = DB::select("SELECT * 
        FROM marcas
        WHERE marca = ?", [$marca]);

        echo json_encode($marcas); // para pasar en json
    }



    
     public function store(Request $request)
    {
        $marca = new Marca();
        $marca->marca = $request->input('marca');
        
  
      

        $marca->save(); // para guardar en json

        echo json_encode($marca); // para pasar en json
    }

   

    public function show($marca_id)
    {
        $marcas =Marca::find($marca_id);
        echo json_encode($marcas);
    }
      

   
    public function update(Request $request, $marca_id)
    {
        $marca =Marca::find($marca_id);
         $marca->marca = $request->input('marca');
      
        $marca->save(); // para guardar en json

        echo json_encode($marca); // para pasar en json
    }

  
    public function destroy($marca_id)
    {
        $marca =Marca::find($marca_id);
        $marca->delete();
    }
}
