<?php

namespace App\Http\Controllers;

use App\detalleRespuesto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetalleRespuestoController extends Controller
{
    public function index()
    {
        $equipos = DB::select("SELECT marca, equipo, nombre_repuesto, cantidad_pedido, fecha_solicitud,estatu_solicitud_repuesto , inventarios.id
        FROM detalle_requirimientos
        LEFT JOIN inventarios ON inventario_id = inventarios.id 
        LEFT JOIN equipos_repuestos ON repuesto_id = equipos_repuestos.id
        LEFT JOIN marcas ON inventarios.marca_id = marcas.id
        LEFT JOIN equipos ON inventarios.equipo_id = equipos.id
        LEFT JOIN estatus_solicitud_repuestos ON estatu_solicitud_repuesto_id = estatus_solicitud_repuestos.id");
        
        echo json_encode($equipos); // para pasar en json
    }
    




    public function ListadoRespuestosSolicitados()
    {
        $hola = DB::select("SELECT  inventarios.id as idinventario, COUNT(inventarios.id) as total_respuesto_solicitado, marca, equipo, serial, estatu_solicitud_repuesto, modelo,centro_salud
        FROM detalle_requirimientos
        LEFT JOIN inventarios ON inventario_id = inventarios.id
        LEFT JOIN centro_salud ON centro_salud_id = centro_salud.id
        LEFT JOIN equipos_repuestos ON repuesto_id = equipos_repuestos.id
        LEFT JOIN marcas ON inventarios.marca_id = marcas.id
        LEFT JOIN equipos ON inventarios.equipo_id = equipos.id
        LEFT JOIN estatus_solicitud_repuestos ON estatu_solicitud_repuesto_id = estatus_solicitud_repuestos.id
        GROUP BY inventarios.id");
        echo json_encode($hola); // para pasar en json
    }
    












    public function detallesMisRespuestosInventarios($inventario_id)
    {
        $equipos = DB::select("SELECT detalle_requirimientos.id as id_requerimiento, marca, equipo, nombre_repuesto, cantidad_pedido, fecha_solicitud, estatu_solicitud_repuesto , inventarios.id
        FROM detalle_requirimientos
        LEFT JOIN inventarios ON inventario_id = inventarios.id 
        LEFT JOIN equipos_repuestos ON repuesto_id = equipos_repuestos.id
        LEFT JOIN marcas ON inventarios.marca_id = marcas.id
        LEFT JOIN equipos ON inventarios.equipo_id = equipos.id
        LEFT JOIN estatus_solicitud_repuestos ON estatu_solicitud_repuesto_id = estatus_solicitud_repuestos.id
        WHERE inventarios.id = ?
", [$inventario_id]);
        echo json_encode($equipos); // para pasar en json
    }

    
     public function store(Request $request)
    {
        $equipo = new detalleRespuesto();
        $equipo->inventario_id = $request->input('inventario_id');
        $equipo->repuesto_id = $request->input('repuesto_id');
        $equipo->cantidad_pedido = $request->input('cantidad_pedido');
        $equipo->fecha_solicitud = $request->input('fecha_solicitud');
        $equipo->user_id = $request->input('user_id');
        $equipo->estatu_solicitud_repuesto_id = $request->input('estatu_solicitud_repuesto_id');

        
       
        
  
      

        $equipo->save(); // para guardar en json

        echo json_encode($equipo); // para pasar en json
    }


    public function actualizarSolicitudEstatus(Request $request, $estatu_id)
    {
        $equipo->estatu_solicitud_repuesto_id = $request->input('estatu_solicitud_repuesto_id');

        
       
        
  
      

        $equipo->save(); // para guardar en json

        echo json_encode($equipo); // para pasar en json
    }

   

    public function show($equipo_id)
    {
        $equipos =detalleRespuesto::find($equipo_id);
        echo json_encode($equipos);
    }
      

   
    public function update(Request $request, $equipo_id)
    {
        $equipo =detalleRespuesto::find($equipo_id);
        $equipo->repuesto_id = $request->input('repuesto_id');
        $equipo->cantidad_pedido = $request->input('cantidad_pedido');
        $equipo->fecha_solicitud = $request->input('fecha_solicitud');
        $equipo->user_id = $request->input('user_id');
        $equipo->estatu_solicitud_repuesto_id = $request->input('estatu_solicitud_repuesto_id');
      
        $equipo->save(); // para guardar en json

        echo json_encode($equipo); // para pasar en json
    }

  
    public function destroy($equipo_id)
    {
        $equipo =detalleRespuesto::find($equipo_id);
        $equipo->delete();
    }










    // REPORTE PDF DE REPUESTOS DETALLADOS //

    
    public function ReporteEstadalMisRespuestosInventarios($estado_id)
    {
        $equipos = DB::select("SELECT estado, centro_salud,marca, modelo,equipo, nombre_repuesto, cantidad_pedido, fecha_solicitud
        FROM detalle_requirimientos
        LEFT JOIN inventarios ON inventario_id = inventarios.id
        LEFT JOIN estados ON inventarios.estado_id = estados.id
        LEFT JOIN centro_salud ON inventarios.centro_salud_id = centro_salud.id
        LEFT JOIN equipos_repuestos ON repuesto_id = equipos_repuestos.id
        LEFT JOIN marcas ON inventarios.marca_id = marcas.id
        LEFT JOIN equipos ON inventarios.equipo_id = equipos.id
        WHERE inventarios.estado_id = ?", [$estado_id]);
        echo json_encode($equipos); // para pasar en json
    }
}
