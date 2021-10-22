<?php

namespace App\Http\Controllers;

use App\MultimediaInventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MultimediaInventarioController extends Controller
{
       public function index()
    {
        $multimedias = MultimediaInventario::get();
        echo json_encode($multimedias);
    }
    




    public function InventarioGaleriaFotos($inventario_id)
    {
        $inventarios = DB::select("SELECT * 
        FROM multimedia_inventarios
        WHERE inventario_id = ?", [$inventario_id]);

        echo json_encode($inventarios); // para pasar en json



    }




    
     public function store(Request $request)
    {
        $fileName = time().'int.png';
        $path = $request->file('imagen')->move(public_path("/uploads/galeria/inventario"), $fileName);
        $photoURL = url('/uploads/galeria/inventario', $fileName);


        $multimedia = new MultimediaInventario();
        $multimedia->imagen = $photoURL;
        $multimedia->nombre_archivo = $fileName;
        $multimedia->inventario_id = $request->input('inventario_id');

        $multimedia->save();

       }

   

    public function show($multimedia_id)
    {
        $multimedias =MultimediaInventario::find($multimedia_id);
        echo json_encode($multimedias);
    }
      

   
    public function update(Request $request, $multimedia_id)
    {
        $multimedia =MultimediaInventario::find($multimedia_id);
         $multimedia->multimedia = $request->input('multimedia');
      
        $multimedia->save(); // para guardar en json

        echo json_encode($multimedia); // para pasar en json
    }

  
    public function destroy($multimedia_id)
    {
        $multimedia =MultimediaInventario::find($multimedia_id);
        $multimedia->delete();
    }
}
