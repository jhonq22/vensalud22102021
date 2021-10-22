<?php

namespace App\Http\Controllers;

use App\BibliotecaVirtual;
use Illuminate\Http\Request;

class BibliotecaVirtualController extends Controller
{
    public function index()
    {
        $bibliotecas =BibliotecaVirtual::get();
        echo json_encode($bibliotecas);
    }
    

    
     public function store(Request $request)
    {

      







/*
        $fileName = time().'int.png';
        $path = $request->file('url_archivo')->move(public_path("/uploads/bibliotecas"), $fileName);
        $photoURL = url('/uploads/bibliotecas'. $fileName);
     */      


    $image = $request->file('url_archivo');
    $imageName = time().rand(1,100).$image->getClientOriginalName();
    $image->move(public_path('/uploads/bibliotecas'),$imageName);
    $photoURL = url('/uploads/bibliotecas/'. $imageName);



        $biblioteca = new BibliotecaVirtual();
        $biblioteca->tipo_bibloteca = $request->input('tipo_bibloteca');
        $biblioteca->equipo = $request->input('equipo');
        $biblioteca->marca = $request->input('marca');
        $biblioteca->modelo = $request->input('modelo');
        $biblioteca->url_archivo = $photoURL;
        //$biblioteca->url_archivo = $request->input('url_archivo');
        $biblioteca->descripcion = $request->input('descripcion');
        
  
      

        $biblioteca->save(); // para guardar en json

        echo json_encode($biblioteca); // para pasar en json
    }

   

    public function show($biblioteca_id)
    {
        $bibliotecas =BibliotecaVirtual::find($biblioteca_id);
        echo json_encode($bibliotecas);
    }
      

   
    public function update(Request $request, $biblioteca_id)
    {

        

        $biblioteca =BibliotecaVirtual::find($biblioteca_id);
        $biblioteca->tipo_bibloteca = $request->input('tipo_bibloteca');
        $biblioteca->equipo = $request->input('equipo');
        $biblioteca->marca = $request->input('marca');
        $biblioteca->modelo = $request->input('modelo');
        $biblioteca->descripcion = $request->input('descripcion');
      
        $biblioteca->save(); // para guardar en json

        echo json_encode($biblioteca); // para pasar en json
    }

  
    public function destroy($biblioteca_id)
    {
        $biblioteca =BibliotecaVirtual::find($biblioteca_id);
        $biblioteca->delete();
    }
}
