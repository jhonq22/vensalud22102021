<?php

namespace App\Http\Controllers;

use App\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\InventarioImport;

class InventarioController extends Controller
{
    public function index()
    {
        $inventarios = DB::select("SELECT inventarios.id, estado, municipio, centro_salud, servicio_medico, piso, equipo, marca, modelo, serial, numero_bien_nacional, proveedor, estatu_equipo, observacion, reparado, fecha_instalacion, proveedor_servicio, name, inventarios.created_at 
            FROM inventarios
            LEFT JOIN estados ON estado_id = estados.id
            LEFT JOIN municipios ON municipio_id = municipios.id
            LEFT JOIN centro_salud ON centro_salud_id = centro_salud.id
            LEFT JOIN estatu_equipos ON estatu_equipo_id = estatu_equipos.id
            LEFT JOIN equipos ON inventarios.equipo_id = equipos.id
            LEFT JOIN marcas ON inventarios.marca_id = marcas.id
            LEFT JOIN users ON user_id = users.id
            ORDER BY inventarios.id DESC");

        echo json_encode($inventarios); // para pasar en json
    }


    // Equipos No operativos general //

    public function equiposno()
    {
        $inventariow = DB::select("SELECT inventarios.id, estado, municipio, centro_salud, servicio_medico, piso, equipo, marca, modelo, serial, numero_bien_nacional, proveedor, estatu_equipo, observacion, reparado, fecha_instalacion, proveedor_servicio, name, inventarios.created_at
        FROM inventarios
        LEFT JOIN estados ON estado_id = estados.id
        LEFT JOIN municipios ON municipio_id = municipios.id
        LEFT JOIN centro_salud ON centro_salud_id = centro_salud.id
        LEFT JOIN estatu_equipos ON estatu_equipo_id = estatu_equipos.id
        LEFT JOIN equipos ON inventarios.equipo_id = equipos.id
        LEFT JOIN marcas ON inventarios.marca_id = marcas.id
        LEFT JOIN users ON user_id = users.id
        WHERE estatu_equipo_id = '3' OR estatu_equipo_id='4'
    
        ORDER BY inventarios.id DESC");

        echo json_encode($inventariow); // para pasar en json
    }
    


    public function equiposnoEstadal($estado_id)
    {
        $inventariow = DB::select("SELECT inventarios.id, inventarios.estatu_equipo_id, estado, municipio, centro_salud, servicio_medico, piso, equipo, marca, modelo, serial, numero_bien_nacional, proveedor, estatu_equipo, observacion, reparado, fecha_instalacion, proveedor_servicio, name, inventarios.created_at
        FROM inventarios
        LEFT JOIN estados ON estado_id = estados.id
        LEFT JOIN municipios ON municipio_id = municipios.id
        LEFT JOIN centro_salud ON centro_salud_id = centro_salud.id
        LEFT JOIN estatu_equipos ON estatu_equipo_id = estatu_equipos.id
        LEFT JOIN equipos ON inventarios.equipo_id = equipos.id
        LEFT JOIN marcas ON inventarios.marca_id = marcas.id
        LEFT JOIN users ON user_id = users.id
        WHERE NOT inventarios.estatu_equipo_id='1' AND NOT inventarios.estatu_equipo_id='2' AND  inventarios.estado_id = ?
        
        ORDER BY inventarios.id DESC",  [$estado_id]);

        echo json_encode($inventariow); // para pasar en json
    }




    public function InventarioDetallada($inventario_id)
    {
        $inventario_detallado = DB::select("SELECT inventarios.id, estado, municipio, centro_salud, servicio_medico, piso, equipo, marca, modelo, serial, numero_bien_nacional, proveedor, estatu_equipo, observacion, reparado, fecha_instalacion, proveedor_servicio, name, inventarios.created_at 
            FROM inventarios
            LEFT JOIN estados ON estado_id = estados.id
            LEFT JOIN municipios ON municipio_id = municipios.id
            LEFT JOIN centro_salud ON centro_salud_id = centro_salud.id
           
            LEFT JOIN estatu_equipos ON estatu_equipo_id = estatu_equipos.id
            LEFT JOIN equipos ON inventarios.equipo_id = equipos.id
            LEFT JOIN marcas ON inventarios.marca_id = marcas.id
            LEFT JOIN users ON user_id = users.id
            WHERE inventarios.id = ?

            ", [$inventario_id]);

        echo json_encode($inventario_detallado); // para pasar en json

    }
    


    //ESTADISTICAS //

public function EstatusEquiposInventariosContar()
    {
        $inventariocontar = DB::select("SELECT COUNT(*) as equipos, estatu_equipo_id, estatu_equipo 
            FROM inventarios 
            LEFT JOIN estatu_equipos ON estatu_equipo_id = estatu_equipos.id 
            GROUP BY estatu_equipo_id, estatu_equipo");

        echo json_encode($inventariocontar); // para pasar en json
    }


     public function EstatusEquiposInventariosContarEstados($inventario_id)
    {
        $inventariocontar = DB::select("SELECT COUNT(*) as equipos, estatu_equipo_id, estatu_equipo 
            FROM inventarios 
            LEFT JOIN estatu_equipos ON estatu_equipo_id = estatu_equipos.id 
            WHERE estado_id = ?
            GROUP BY estatu_equipo_id, estatu_equipo", [$inventario_id]);

        echo json_encode($inventariocontar); // para pasar en json
    }





    public function EstatusEquiposInventariosContarCentroSalud($inventario_id)
    {
        $inventariocontar = DB::select("SELECT COUNT(*) as equipos, estatu_equipo_id, estatu_equipo 
            FROM inventarios 
            LEFT JOIN estatu_equipos ON estatu_equipo_id = estatu_equipos.id 
            WHERE centro_salud_id = ?
            GROUP BY estatu_equipo_id, estatu_equipo", [$inventario_id]);

        echo json_encode($inventariocontar); // para pasar en json
    }







 public function totalInventario()
    {
        $inventarios = DB::select("SELECT COUNT(*) as inventarios
                                   FROM inventarios");
        echo json_encode($inventarios); // para pasar en json

    }


    public function totalInventarioPorEstados($inventario_id)
    {
        $inventarios = DB::select("SELECT COUNT(*) as inventarios
                                   FROM inventarios
                                   WHERE estado_id = ?", [$inventario_id]);
        echo json_encode($inventarios); // para pasar en json

    }


public function totalInventarioPorCentroSalud($inventario_id)
    {
        $inventarios = DB::select("SELECT COUNT(*) as inventarios
                                   FROM inventarios
                                   WHERE centro_salud_id = ?", [$inventario_id]);
        echo json_encode($inventarios); // para pasar en json

    }





    
    //ESTADISTICAS

    
     public function store(Request $request)
    {
        $inventario = new Inventario();
        $inventario->estado_id = $request->input('estado_id');
        $inventario->municipio_id = $request->input('municipio_id');
        $inventario->centro_salud_id = $request->input('centro_salud_id');
        $inventario->servicio_medico = $request->input('servicio_medico');
        $inventario->piso = $request->input('piso');
        $inventario->equipo_id = $request->input('equipo_id');
        $inventario->marca_id = $request->input('marca_id');
        $inventario->modelo = $request->input('modelo');
        $inventario->serial = $request->input('serial');
        $inventario->numero_bien_nacional = $request->input('numero_bien_nacional');
        $inventario->proveedor = $request->input('proveedor');
        $inventario->estatu_equipo_id = $request->input('estatu_equipo_id');
        $inventario->observacion = $request->input('observacion');
        $inventario->reparado = $request->input('reparado');
        $inventario->fecha_instalacion = $request->input('fecha_instalacion');
        $inventario->proveedor_servicio = $request->input('observacion');
        $inventario->user_id = $request->input('user_id');


  
      

        $inventario->save(); // para guardar en json

        echo json_encode($inventario); // para pasar en json
    }

   

    public function show($inventario_id)
    {
        $inventarios =Inventario::find($inventario_id);
        echo json_encode($inventarios);
    }
      

   
    public function update(Request $request, $inventario_id)
    {
        $inventario =Inventario::find($inventario_id);
        $inventario->estado_id = $request->input('estado_id');
        $inventario->municipio_id = $request->input('municipio_id');
        $inventario->centro_salud_id = $request->input('centro_salud_id');
        $inventario->servicio_medico = $request->input('servicio_medico');
        $inventario->piso = $request->input('piso');
        $inventario->equipo_id = $request->input('equipo_id');
        $inventario->marca_id = $request->input('marca_id');
        $inventario->modelo = $request->input('modelo');
        $inventario->serial = $request->input('serial');
        $inventario->numero_bien_nacional = $request->input('numero_bien_nacional');
        $inventario->proveedor = $request->input('proveedor');
        $inventario->estatu_equipo_id = $request->input('estatu_equipo_id');
        $inventario->observacion = $request->input('observacion');
        $inventario->reparado = $request->input('reparado');
        $inventario->fecha_instalacion = $request->input('fecha_instalacion');
        $inventario->proveedor_servicio = $request->input('observacion');
        $inventario->user_id = $request->input('user_id');
        
      
        $inventario->save(); // para guardar en json

        echo json_encode($inventario); // para pasar en json
    }

  
    public function destroy($inventario_id)
    {
        $inventario =Inventario::find($inventario_id);
        $inventario->delete();
    }






    //QUERY PARA VER LISTADO INVENTARIO POR ESTADOS


public function InventarioPorEstados($inventario_id)
{
    $inventario_detallado = DB::select("SELECT inventarios.id, estado, municipio, centro_salud, servicio_medico, piso, equipo_id, marca_id, modelo, serial, numero_bien_nacional, proveedor, estatu_equipo, observacion, reparado, fecha_instalacion, proveedor_servicio, name, inventarios.created_at 
        FROM inventarios 
        LEFT JOIN estados ON estado_id = estados.id
        LEFT JOIN municipios ON municipio_id = municipios.id
        LEFT JOIN centro_salud ON centro_salud_id = centro_salud.id
      
        LEFT JOIN estatu_equipos ON estatu_equipo_id = estatu_equipos.id
        LEFT JOIN users ON user_id = users.id
        WHERE inventarios.estado_id = ?
         ORDER BY inventarios.id DESC
        ", [$inventario_id]);

    echo json_encode($inventario_detallado); // para pasar en json

}





//QUERY PARA VER LISTADO INVENTARIO POR Municipios


public function InventarioPorMunicipio($inventario_id)
    {
        $inventario_detallado = DB::select("SELECT inventarios.id, estado, municipio, centro_salud, servicio_medico, piso, equipo_id, marca_id, modelo, serial, numero_bien_nacional, proveedor, estatu_equipo, observacion, reparado, fecha_instalacion, proveedor_servicio, name, inventarios.created_at 
            FROM inventarios 
            LEFT JOIN estados ON estado_id = estados.id
            LEFT JOIN municipios ON municipio_id = municipios.id
            LEFT JOIN centro_salud ON centro_salud_id = centro_salud.id
          
            LEFT JOIN estatu_equipos ON estatu_equipo_id = estatu_equipos.id
            LEFT JOIN users ON user_id = users.id
            WHERE inventarios.municipio_id = ?
             ORDER BY inventarios.id DESC
            ", [$inventario_id]);

        echo json_encode($inventario_detallado); // para pasar en json

    }




// QUERY PARA VER EL LISTADO DE INVENTARIO POR CENTRO DE SALUD

public function InventarioPorCentroSalud($inventario_id)
    {
        $inventario_detallado = DB::select("SELECT inventarios.id, estado, municipio, centro_salud, servicio_medico, piso, equipo_id, marca_id, modelo, serial, numero_bien_nacional, proveedor, estatu_equipo, observacion, reparado, fecha_instalacion, proveedor_servicio, name, inventarios.created_at 
            FROM inventarios 
            LEFT JOIN estados ON estado_id = estados.id
            LEFT JOIN municipios ON municipio_id = municipios.id
            LEFT JOIN centro_salud ON centro_salud_id = centro_salud.id
          
            LEFT JOIN estatu_equipos ON estatu_equipo_id = estatu_equipos.id
            LEFT JOIN users ON user_id = users.id
            WHERE inventarios.centro_salud_id = ?
             ORDER BY inventarios.id DESC
            ", [$inventario_id]);

        echo json_encode($inventario_detallado); // para pasar en json

    }

// ímportar masivo excel

public function import() 

    {
      $data = Excel::import(new InventarioImport,request()->file('file'));

    echo json_encode($data);

        

    }



    public function inventarioMarcaDuplicado($marca_id, $serial)
    {
        $invetariomarca = DB::select("SELECT  marca_id, serial 
            FROM inventarios 
            WHERE marca_id = ? AND serial = ?
           ",[$marca_id, $serial]  );

        echo json_encode($invetariomarca); // para pasar en json
    }


    public function TablaEquipos()
    {
        $tabla = DB::select("SELECT e.estado,
        (SELECT count(estatu_equipo_id) FROM inventarios WHERE estatu_equipo_id in (1,2) AND e.id=estado_id) AS equipos_operativos,
        (SELECT count(estatu_equipo_id) FROM inventarios WHERE estatu_equipo_id in (3,4) AND e.id=estado_id) AS equipos_inoperativos,
        (SELECT count(estatu_equipo_id) FROM inventarios WHERE e.id=estado_id) AS total_equipos,
        (((SELECT count(estatu_equipo_id) FROM inventarios WHERE estatu_equipo_id in (1,2) AND e.id=estado_id) * 100)/ (SELECT count(estatu_equipo_id) FROM inventarios where e.id=estado_id)) AS coeficiente_disponibilidad_tecnica
        FROM estados AS e
        INNER JOIN inventarios AS i on i.estado_id=e.id
        INNER JOIN estatu_equipos AS h on h.id=i.estatu_equipo_id
        GROUP BY e.estado, equipos_operativos, equipos_inoperativos
        ORDER BY e.estado");

        echo json_encode($tabla); // para pasar en json
    }


    public function CoeficienteGeneralEquipos()
    {
        $tabla = DB::select("SELECT         
        (((SELECT count(estatu_equipo_id) FROM inventarios WHERE estatu_equipo_id in (1,2)) * 100)/ (SELECT count(estatu_equipo_id) FROM inventarios )) AS coeficiente_disponibilidad_general
        FROM estados AS e
        INNER JOIN inventarios AS i on i.estado_id=e.id
        LIMIT 1");

        echo json_encode($tabla); // para pasar en json
    }




    //REPORTES PDF //

    public function ReporteInventarioGeneral($fecha1, $fecha2, $fecha3, $fecha4)
    {
        $inventarios = DB::select("SELECT  distinct historico_estatus.inventario_id as codigo_vensalud, centro_salud, estado, servicio_medico, equipo, marca, serial, numero_bien_nacional, reparado, estatu_equipo, historico_estatus.observacion, DATE_FORMAT(historico_estatus.created_at,'%Y-%m-%d') as fecha_creado_estatus,
        DATE_FORMAT(inventarios.created_at,'%Y-%m-%d') AS fecha_registro
        FROM inventarios
        JOIN historico_estatus ON historico_estatus.inventario_id = inventarios.id AND (DATE(historico_estatus.created_at) BETWEEN  ? AND ?)
        JOIN estados ON estado_id = estados.id 
        JOIN municipios ON municipio_id = municipios.id 
        JOIN centro_salud ON inventarios.centro_salud_id = centro_salud.id  
        JOIN estatu_equipos ON inventarios.estatu_equipo_id = estatu_equipos.id
        JOIN equipos ON inventarios.equipo_id = equipos.id
        JOIN marcas ON inventarios.marca_id = marcas.id
        
        UNION ALL
        
        SELECT distinct  inventarios.id AS codigo_vensalud, centro_salud, estado, servicio_medico, equipo, marca, serial, numero_bien_nacional, reparado, estatu_equipo, '' AS observacion,
        '' AS fecha_creado_estatus,
        DATE_FORMAT(inventarios.created_at,'%Y-%m-%d') AS fecha_registro
        FROM inventarios
        JOIN estados ON estado_id = estados.id  
        JOIN municipios ON municipio_id = municipios.id 
        JOIN centro_salud ON inventarios.centro_salud_id = centro_salud.id  
        JOIN estatu_equipos ON inventarios.estatu_equipo_id = estatu_equipos.id
        JOIN equipos ON inventarios.equipo_id = equipos.id
        JOIN marcas ON inventarios.marca_id = marcas.id
        WHERE inventarios.created_at BETWEEN  ? AND ?
        order by fecha_registro", [$fecha1, $fecha2, $fecha3, $fecha4]);

        echo json_encode($inventarios); // para pasar en json
    }



    public function ReporteInventarioEstadal($fecha1, $fecha2,$estado_id1,$estado_id2, $fecha3, $fecha4 )
    {
        $inventarios = DB::select("SELECT  distinct historico_estatus.inventario_id as codigo_vensalud, centro_salud, estado, servicio_medico, equipo, marca, serial, numero_bien_nacional, reparado, estatu_equipo, historico_estatus.observacion, DATE_FORMAT(historico_estatus.created_at,'%Y-%m-%d') as fecha_creado_estatus,
        DATE_FORMAT(inventarios.created_at,'%Y-%m-%d') AS fecha_registro
        FROM inventarios
        JOIN historico_estatus ON historico_estatus.inventario_id = inventarios.id AND (DATE(historico_estatus.created_at) BETWEEN  ? AND ?)
        JOIN estados ON estado_id = estados.id = ? 
        JOIN municipios ON municipio_id = municipios.id 
        JOIN centro_salud ON inventarios.centro_salud_id = centro_salud.id  
        JOIN estatu_equipos ON inventarios.estatu_equipo_id = estatu_equipos.id
        JOIN equipos ON inventarios.equipo_id = equipos.id
        JOIN marcas ON inventarios.marca_id = marcas.id
        
        UNION ALL
        
        SELECT distinct  inventarios.id AS codigo_vensalud, centro_salud, estado, servicio_medico, equipo, marca, serial, numero_bien_nacional, reparado, estatu_equipo, '' AS observacion,
        '' AS fecha_creado_estatus,
        DATE_FORMAT(inventarios.created_at,'%Y-%m-%d') AS fecha_registro
        FROM inventarios
        JOIN estados ON estado_id = estados.id  = ? 
        JOIN municipios ON municipio_id = municipios.id 
        JOIN centro_salud ON inventarios.centro_salud_id = centro_salud.id  
        JOIN estatu_equipos ON inventarios.estatu_equipo_id = estatu_equipos.id
        JOIN equipos ON inventarios.equipo_id = equipos.id
        JOIN marcas ON inventarios.marca_id = marcas.id
        WHERE inventarios.created_at BETWEEN  ? AND ?
        order by fecha_registro", [$fecha1, $fecha2, $estado_id1, $estado_id2, $fecha3, $fecha4] );

        echo json_encode($inventarios); // para pasar en json
    }


    public function ReporteInventarioMunicipal($fecha1, $fecha2, $municipio_id1, $municipio_id2, $fecha3, $fecha4)
    {
        $inventarios = DB::select("SELECT  distinct historico_estatus.inventario_id as codigo_vensalud, centro_salud, estado, servicio_medico, equipo, marca, serial, numero_bien_nacional, reparado, estatu_equipo, historico_estatus.observacion, DATE_FORMAT(historico_estatus.created_at,'%Y-%m-%d') as fecha_creado_estatus,
        DATE_FORMAT(inventarios.created_at,'%Y-%m-%d') AS fecha_registro
        FROM inventarios
        JOIN historico_estatus ON historico_estatus.inventario_id = inventarios.id AND (DATE(historico_estatus.created_at) BETWEEN  ? AND ?)
        JOIN estados ON estado_id = estados.id 
        JOIN municipios ON municipio_id = municipios.id = ? 
        JOIN centro_salud ON inventarios.centro_salud_id = centro_salud.id  
        JOIN estatu_equipos ON inventarios.estatu_equipo_id = estatu_equipos.id
        JOIN equipos ON inventarios.equipo_id = equipos.id
        JOIN marcas ON inventarios.marca_id = marcas.id
        
        UNION ALL
        
        SELECT distinct  inventarios.id AS codigo_vensalud, centro_salud, estado, servicio_medico, equipo, marca, serial, numero_bien_nacional, reparado, estatu_equipo, '' AS observacion,
        '' AS fecha_creado_estatus,
        DATE_FORMAT(inventarios.created_at,'%Y-%m-%d') AS fecha_registro
        FROM inventarios
        JOIN estados ON estado_id = estados.id 
        JOIN municipios ON municipio_id = municipios.id = ? 
        JOIN centro_salud ON inventarios.centro_salud_id = centro_salud.id  
        JOIN estatu_equipos ON inventarios.estatu_equipo_id = estatu_equipos.id
        JOIN equipos ON inventarios.equipo_id = equipos.id
        JOIN marcas ON inventarios.marca_id = marcas.id
        WHERE inventarios.created_at BETWEEN  ? AND ?
        order by fecha_registro", [$fecha1, $fecha2, $municipio_id1, $municipio_id2, $fecha3, $fecha4] );

        echo json_encode($inventarios); // para pasar en json
    }

    public function ReporteInventarioCentroSalud($fecha1, $fecha2, $centro_salud_id1, $centro_salud_id2, $fecha3, $fecha4)
    {
        $inventarios = DB::select("SELECT  distinct historico_estatus.inventario_id as codigo_vensalud, centro_salud, estado, servicio_medico, equipo, marca, serial, numero_bien_nacional, reparado, estatu_equipo, historico_estatus.observacion, DATE_FORMAT(historico_estatus.created_at,'%Y-%m-%d') as fecha_creado_estatus,
        DATE_FORMAT(inventarios.created_at,'%Y-%m-%d') AS fecha_registro
        FROM inventarios
        JOIN historico_estatus ON historico_estatus.inventario_id = inventarios.id AND (DATE(historico_estatus.created_at) BETWEEN  ? AND ?)
        JOIN estados ON estado_id = estados.id 
        JOIN municipios ON municipio_id = municipios.id = ? 
        JOIN centro_salud ON inventarios.centro_salud_id = centro_salud.id  
        JOIN estatu_equipos ON inventarios.estatu_equipo_id = estatu_equipos.id
        JOIN equipos ON inventarios.equipo_id = equipos.id
        JOIN marcas ON inventarios.marca_id = marcas.id
        
        UNION ALL
        
        SELECT distinct  inventarios.id AS codigo_vensalud, centro_salud, estado, servicio_medico, equipo, marca, serial, numero_bien_nacional, reparado, estatu_equipo, '' AS observacion,
        '' AS fecha_creado_estatus,
        DATE_FORMAT(inventarios.created_at,'%Y-%m-%d') AS fecha_registro
        FROM inventarios
        JOIN estados ON estado_id = estados.id 
        JOIN municipios ON municipio_id = municipios.id = ? 
        JOIN centro_salud ON inventarios.centro_salud_id = centro_salud.id  
        JOIN estatu_equipos ON inventarios.estatu_equipo_id = estatu_equipos.id
        JOIN equipos ON inventarios.equipo_id = equipos.id
        JOIN marcas ON inventarios.marca_id = marcas.id
        WHERE inventarios.created_at BETWEEN  ? AND ?
        order by fecha_registro", [$fecha1, $fecha2, $centro_salud_id1, $centro_salud_id2, $fecha3, $fecha4] );

        echo json_encode($inventarios); // para pasar en json
    }
    
    

      //REPORTES PDF ESTADOS Y ESTATUS //



      public function ReporteInventarioGeneralPorEstatus($equipo_id,$estatu_equipo_id, $fecha1, $fecha2, $fecha3, $fecha4)
      {

        //$equipo = '%'.$equipo.'%';  
          $inventarios = DB::select("SELECT  historico_estatus.inventario_id, centro_salud, estado, servicio_medico, equipo, marca, serial, numero_bien_nacional, reparado, estatu_equipo, historico_estatus.observacion, historico_estatus.created_at, 
          historico_estatus.updated_at
          FROM historico_estatus
          LEFT JOIN inventarios ON historico_estatus.inventario_id = inventarios.id
          LEFT JOIN estados ON estado_id = estados.id
          LEFT JOIN municipios ON municipio_id = municipios.id
          LEFT JOIN centro_salud ON inventarios.centro_salud_id = centro_salud.id
          LEFT JOIN estatu_equipos ON inventarios.estatu_equipo_id = estatu_equipos.id
          LEFT JOIN equipos ON inventarios.equipo_id = equipos.id
          LEFT JOIN marcas ON inventarios.marca_id = marcas.id
          WHERE inventarios.equipo_id = ? AND inventarios.estatu_equipo_id = ? AND 
          (DATE(historico_estatus.created_at) BETWEEN  ? AND ? OR
           DATE(historico_estatus.updated_at) BETWEEN  ? AND ?)
          ORDER BY inventarios.id DESC", [$equipo_id, $estatu_equipo_id, $fecha1, $fecha2, $fecha3, $fecha4]);
  
          echo json_encode($inventarios); // para pasar en json
      }
  












      public function ReporteInventarioEstadalPorEstatus($equipo_id, $estado_id, $estatu_equipo_id, $fecha1, $fecha2, $fecha3, $fecha4)
      {

        //$equipo = '%'.$equipo.'%';  
          $inventarios = DB::select("SELECT  historico_estatus.inventario_id, centro_salud, estado, servicio_medico, equipo, marca, serial, numero_bien_nacional, reparado, estatu_equipo, historico_estatus.observacion, historico_estatus.created_at,
          historico_estatus.updated_at
          FROM historico_estatus
          LEFT JOIN inventarios ON historico_estatus.inventario_id = inventarios.id
          LEFT JOIN estados ON estado_id = estados.id
          LEFT JOIN municipios ON municipio_id = municipios.id
          LEFT JOIN centro_salud ON inventarios.centro_salud_id = centro_salud.id
          LEFT JOIN estatu_equipos ON inventarios.estatu_equipo_id = estatu_equipos.id
          LEFT JOIN equipos ON inventarios.equipo_id = equipos.id
          LEFT JOIN marcas ON inventarios.marca_id = marcas.id
          WHERE inventarios.equipo_id = ? AND inventarios.estado_id = ?  AND inventarios.estatu_equipo_id = ? AND 
          (DATE(historico_estatus.created_at) BETWEEN  ? AND ? OR
           DATE(historico_estatus.updated_at) BETWEEN  ? AND ?)
          ORDER BY inventarios.id DESC", [$equipo_id, $estado_id, $estatu_equipo_id, $fecha1, $fecha2, $fecha3, $fecha4 ]);
  
          echo json_encode($inventarios); // para pasar en json
      }
  
  
      public function ReporteInventarioMunicipalPorEstatus($equipo_id, $municipio_id, $estatu_equipo_id, $fecha1, $fecha2, $fecha3, $fecha4)
      {
        //$equipo = '%'.$equipo.'%'; 
          $inventarios = DB::select("SELECT  historico_estatus.inventario_id, centro_salud, estado, servicio_medico, equipo, marca, serial, numero_bien_nacional, reparado, estatu_equipo, historico_estatus.observacion, historico_estatus.created_at,
          historico_estatus.updated_at
          FROM historico_estatus
          LEFT JOIN inventarios ON historico_estatus.inventario_id = inventarios.id
          LEFT JOIN estados ON estado_id = estados.id
          LEFT JOIN municipios ON municipio_id = municipios.id
          LEFT JOIN centro_salud ON inventarios.centro_salud_id = centro_salud.id
          LEFT JOIN estatu_equipos ON inventarios.estatu_equipo_id = estatu_equipos.id
          LEFT JOIN equipos ON inventarios.equipo_id = equipos.id
          LEFT JOIN marcas ON inventarios.marca_id = marcas.id
          WHERE inventarios.equipo_id = ? AND inventarios.municipio_id = ?  AND inventarios.estatu_equipo_id = ? AND 
          (DATE(historico_estatus.created_at) BETWEEN  ? AND ? OR
           DATE(historico_estatus.updated_at) BETWEEN  ? AND ?)
          ORDER BY inventarios.id DESC", [$equipo_id ,$municipio_id, $estatu_equipo_id, $fecha1, $fecha2, $fecha3, $fecha4] );
  
          echo json_encode($inventarios); // para pasar en json
      }
  
      public function ReporteInventarioCentroSaludPorEstatus($equipo_id ,$centro_salud_id, $estatu_equipo_id, $fecha1, $fecha2, $fecha3, $fecha4)
      {
        //$equipo = '%'.$equipo.'%'; 
          $inventarios = DB::select("SELECT  historico_estatus.inventario_id, centro_salud, estado, servicio_medico, equipo, marca, serial, numero_bien_nacional, reparado, estatu_equipo, historico_estatus.observacion, historico_estatus.created_at,
          historico_estatus.updated_at
          FROM historico_estatus
          LEFT JOIN inventarios ON historico_estatus.inventario_id = inventarios.id
          LEFT JOIN estados ON estado_id = estados.id
          LEFT JOIN municipios ON municipio_id = municipios.id
          LEFT JOIN centro_salud ON inventarios.centro_salud_id = centro_salud.id
          LEFT JOIN estatu_equipos ON inventarios.estatu_equipo_id = estatu_equipos.id
          LEFT JOIN equipos ON inventarios.equipo_id = equipos.id
          LEFT JOIN marcas ON inventarios.marca_id = marcas.id
          WHERE inventarios.equipo_id = ? AND inventarios.centro_salud_id = ?  AND inventarios.estatu_equipo_id = ? AND 
          (DATE(historico_estatus.created_at) BETWEEN  ? AND ? OR
           DATE(historico_estatus.updated_at) BETWEEN  ? AND ?)
          ORDER BY inventarios.id DESC", [$equipo_id ,$centro_salud_id, $estatu_equipo_id, $fecha1, $fecha2, $fecha3, $fecha4] );
  
          echo json_encode($inventarios); // para pasar en json
      }



       //REPORTES PDF ESTADOS Y REPARADO //


       public function ReporteInventarioEstadalPorReparados($equipo_id ,$estado_id, $reparado, $fecha1, $fecha2)
       {
           //$equipo = '%'.$equipo.'%'; 
           $inventarios = DB::select("SELECT  historico_estatus.inventario_id, centro_salud, servicio_medico, equipo, marca, serial, numero_bien_nacional, reparado, estatu_equipo, historico_estatus.created_at
           FROM historico_estatus
           LEFT JOIN inventarios ON historico_estatus.inventario_id = inventarios.id
           LEFT JOIN estados ON estado_id = estados.id
           LEFT JOIN municipios ON municipio_id = municipios.id
           LEFT JOIN centro_salud ON inventarios.centro_salud_id = centro_salud.id
           LEFT JOIN estatu_equipos ON inventarios.estatu_equipo_id = estatu_equipos.id
           LEFT JOIN equipos ON inventarios.equipo_id = equipos.id
           LEFT JOIN marcas ON inventarios.marca_id = marcas.id
               WHERE inventarios.equipo_id = ? AND inventarios.estado_id = ? AND inventarios.reparado = ? AND DATE(historico_estatus.created_at) BETWEEN  ? AND ?
               ORDER BY inventarios.id DESC", [$equipo_id,$estado_id, $reparado, $fecha1, $fecha2] );
   
           echo json_encode($inventarios); // para pasar en json
       }
   
   
       public function ReporteInventarioMunicipalPorReparados($equipo_id,$municipio_id, $reparado, $fecha1, $fecha2)
       {
             //$equipo = '%'.$equipo.'%'; 
           $inventarios = DB::select("SELECT  historico_estatus.inventario_id, centro_salud, servicio_medico, equipo, marca, serial, numero_bien_nacional, reparado, estatu_equipo, historico_estatus.created_at
           FROM historico_estatus
           LEFT JOIN inventarios ON historico_estatus.inventario_id = inventarios.id
           LEFT JOIN estados ON estado_id = estados.id
           LEFT JOIN municipios ON municipio_id = municipios.id
           LEFT JOIN centro_salud ON inventarios.centro_salud_id = centro_salud.id
           LEFT JOIN estatu_equipos ON inventarios.estatu_equipo_id = estatu_equipos.id
           LEFT JOIN equipos ON inventarios.equipo_id = equipos.id
           LEFT JOIN marcas ON inventarios.marca_id = marcas.id
               WHERE inventarios.equipo_id = ? AND inventarios.municipio_id = ? AND inventarios.reparado = ? AND DATE(historico_estatus.created_at) BETWEEN  ? AND ?
               ORDER BY inventarios.id DESC", [$equipo_id,$municipio_id, $reparado, $fecha1, $fecha2] );
   
           echo json_encode($inventarios); // para pasar en json
       }
   
       public function ReporteInventarioCentroSaludPorReparados($equipo_id,$centro_salud_id, $reparado, $fecha1, $fecha2)
       {
            //$equipo = '%'.$equipo.'%';  
           $inventarios = DB::select("SELECT historico_estatus.inventario_id, centro_salud, servicio_medico, equipo, marca, serial, numero_bien_nacional, reparado, estatu_equipo, historico_estatus.created_at
           FROM historico_estatus
           LEFT JOIN inventarios ON historico_estatus.inventario_id = inventarios.id
           LEFT JOIN estados ON estado_id = estados.id
           LEFT JOIN municipios ON municipio_id = municipios.id
           LEFT JOIN centro_salud ON inventarios.centro_salud_id = centro_salud.id
           LEFT JOIN estatu_equipos ON inventarios.estatu_equipo_id = estatu_equipos.id
           LEFT JOIN equipos ON inventarios.equipo_id = equipos.id
           LEFT JOIN marcas ON inventarios.marca_id = marcas.id
               WHERE inventarios.equipo_id = ? AND inventarios.centro_salud_id = ? AND inventarios.reparado = ? AND DATE(historico_estatus.created_at) BETWEEN  ? AND ?
               ORDER BY inventarios.id DESC", [$equipo_id, $centro_salud_id, $reparado, $fecha1, $fecha2] );
   
           echo json_encode($inventarios); // para pasar en json
       }





        // REPORTE PARA BUSCAR UN LIKE POR EQUIPO DEL INVENTARIO


       public function ReporteInventarioBuscarEquipo($equipo_id, $fecha1, $fecha2)
       {
           //$equipo = '%'.$equipo.'%';
           $inventarios = DB::select("SELECT inventarios.id, estado, municipio, centro_salud, servicio_medico, piso, equipo, marca, modelo, serial, numero_bien_nacional, proveedor, estatu_equipo, observacion, reparado, fecha_instalacion, proveedor_servicio, name, inventarios.created_at 
               FROM inventarios
               LEFT JOIN estados ON estado_id = estados.id
               LEFT JOIN municipios ON municipio_id = municipios.id
               LEFT JOIN centro_salud ON centro_salud_id = centro_salud.id
               LEFT JOIN estatu_equipos ON estatu_equipo_id = estatu_equipos.id
               LEFT JOIN equipos ON inventarios.equipo_id = equipos.id
               LEFT JOIN marcas ON inventarios.marca_id = marcas.id
               LEFT JOIN users ON user_id = users.id
               WHERE inventarios.equipo_id = ? AND DATE(inventarios.created_at) BETWEEN  ? AND ?
               ORDER BY inventarios.id DESC", [$equipo_id, $fecha1, $fecha2] );
   
           echo json_encode($inventarios); // para pasar en json
       }
   


       public function ReporteInventarioBuscarEquipoEstados($equipo_id, $estado_id, $fecha1, $fecha2)
       {
           //$equipo = '%'.$equipo.'%';
           $inventarios = DB::select("SELECT inventarios.id, estado, municipio, centro_salud, servicio_medico, piso, equipo, marca, modelo, serial, numero_bien_nacional, proveedor, estatu_equipo, observacion, reparado, fecha_instalacion, proveedor_servicio, name, inventarios.created_at 
               FROM inventarios
               LEFT JOIN estados ON estado_id = estados.id
               LEFT JOIN municipios ON municipio_id = municipios.id
               LEFT JOIN centro_salud ON centro_salud_id = centro_salud.id
               LEFT JOIN estatu_equipos ON estatu_equipo_id = estatu_equipos.id
               LEFT JOIN equipos ON inventarios.equipo_id = equipos.id
               LEFT JOIN marcas ON inventarios.marca_id = marcas.id
               LEFT JOIN users ON user_id = users.id
               WHERE inventarios.equipo_id = ? AND inventarios.estado_id = ? AND DATE(inventarios.created_at) BETWEEN  ? AND ?
               ORDER BY inventarios.id DESC", [$equipo_id, $estado_id, $fecha1, $fecha2] );
   
           echo json_encode($inventarios); // para pasar en json
       }


       public function ReporteInventarioBuscarEquipoMunicipios($equipo_id, $municipio_id, $fecha1, $fecha2)
       {
           //$equipo = '%'.$equipo.'%';
           $inventarios = DB::select("SELECT inventarios.id, estado, municipio, centro_salud, servicio_medico, piso, equipo, marca, modelo, serial, numero_bien_nacional, proveedor, estatu_equipo, observacion, reparado, fecha_instalacion, proveedor_servicio, name, inventarios.created_at 
               FROM inventarios
               LEFT JOIN estados ON estado_id = estados.id
               LEFT JOIN municipios ON municipio_id = municipios.id
               LEFT JOIN centro_salud ON centro_salud_id = centro_salud.id
               LEFT JOIN estatu_equipos ON estatu_equipo_id = estatu_equipos.id
               LEFT JOIN equipos ON inventarios.equipo_id = equipos.id
               LEFT JOIN marcas ON inventarios.marca_id = marcas.id
               LEFT JOIN users ON user_id = users.id
               WHERE inventarios.equipo_id = ? AND inventarios.municipio_id = ? AND DATE(inventarios.created_at) BETWEEN  ? AND ?
               ORDER BY inventarios.id DESC", [$equipo_id, $municipio_id, $fecha1, $fecha2] );
   
           echo json_encode($inventarios); // para pasar en json
       }


       public function ReporteInventarioBuscarEquipoCentroSalud($equipo_id, $centro_salud_id, $fecha1, $fecha2)
       {
           //$equipo = '%'.$equipo.'%';
           $inventarios = DB::select("SELECT inventarios.id, estado, municipio, centro_salud, servicio_medico, piso, equipo, marca, modelo, serial, numero_bien_nacional, proveedor, estatu_equipo, observacion, reparado, fecha_instalacion, proveedor_servicio, name, inventarios.created_at 
               FROM inventarios
               LEFT JOIN estados ON estado_id = estados.id
               LEFT JOIN municipios ON municipio_id = municipios.id
               LEFT JOIN centro_salud ON centro_salud_id = centro_salud.id
               LEFT JOIN estatu_equipos ON estatu_equipo_id = estatu_equipos.id
               LEFT JOIN equipos ON inventarios.equipo_id = equipos.id
               LEFT JOIN marcas ON inventarios.marca_id = marcas.id
               LEFT JOIN users ON user_id = users.id
               WHERE inventarios.equipo_id = ? AND inventarios.centro_salud_id = ? AND DATE(inventarios.created_at) BETWEEN  ? AND ?
               ORDER BY inventarios.id DESC", [$equipo_id, $centro_salud_id, $fecha1, $fecha2] );
   
           echo json_encode($inventarios); // para pasar en json
       }




 // REPORTES GENERAL GLOBALES //

       public function ReporteInventarioGeneralGlobal($fecha1, $fecha2)
       {
           $inventarios = DB::select("SELECT e.estado,
           (SELECT count(estatu_equipo_id) FROM inventarios WHERE estatu_equipo_id in (1) AND e.id=estado_id) AS equipos_operativos,
           (SELECT count(estatu_equipo_id) FROM inventarios WHERE estatu_equipo_id in (2) AND e.id=estado_id) AS equipos_baja_tecnicas,
           (SELECT count(estatu_equipo_id) FROM inventarios WHERE estatu_equipo_id in (3) AND e.id=estado_id) AS equipos_inoperativos,
           (SELECT count(estatu_equipo_id) FROM inventarios WHERE e.id=estado_id) AS total_equipos
          
           FROM estados AS e
           INNER JOIN inventarios AS i on i.estado_id=e.id
           INNER JOIN estatu_equipos AS h on h.id=i.estatu_equipo_id
           WHERE DATE(i.created_at) BETWEEN  ? AND ?
           GROUP BY e.estado, equipos_operativos, equipos_inoperativos
           ORDER BY e.estado", [$fecha1, $fecha2] );
   
           echo json_encode($inventarios); // para pasar en json
       }


       public function ReporteInventarioGeneralEstadalGlobal($estado_id, $fecha1, $fecha2)
       {
           $inventarios = DB::select("SELECT e.estado,
           (SELECT count(estatu_equipo_id) FROM inventarios WHERE estatu_equipo_id in (1) AND e.id=estado_id) AS equipos_operativos,
           (SELECT count(estatu_equipo_id) FROM inventarios WHERE estatu_equipo_id in (2) AND e.id=estado_id) AS equipos_baja_tecnicas,
           (SELECT count(estatu_equipo_id) FROM inventarios WHERE estatu_equipo_id in (3) AND e.id=estado_id) AS equipos_inoperativos,
           (SELECT count(estatu_equipo_id) FROM inventarios WHERE e.id=estado_id) AS total_equipos
          
           FROM estados AS e
           INNER JOIN inventarios AS i on i.estado_id=e.id
           INNER JOIN estatu_equipos AS h on h.id=i.estatu_equipo_id
           WHERE i.estado_id = ? AND DATE(i.created_at) BETWEEN  ? AND ?
           GROUP BY e.estado, equipos_operativos, equipos_inoperativos
           ORDER BY e.estado", [$estado_id, $fecha1, $fecha2] );
   
           echo json_encode($inventarios); // para pasar en json
       }



       public function ReporteInventarioGeneralMunicipalGlobal($municipio_id, $fecha1, $fecha2)
       {
           $inventarios = DB::select("SELECT e.estado, m.municipio,
           (SELECT count(estatu_equipo_id) FROM inventarios WHERE estatu_equipo_id in (1) AND e.id=estado_id) AS equipos_operativos,
           (SELECT count(estatu_equipo_id) FROM inventarios WHERE estatu_equipo_id in (2) AND e.id=estado_id) AS equipos_baja_tecnicas,
           (SELECT count(estatu_equipo_id) FROM inventarios WHERE estatu_equipo_id in (3) AND e.id=estado_id) AS equipos_inoperativos,
           (SELECT count(estatu_equipo_id) FROM inventarios WHERE e.id=estado_id) AS total_equipos
          
           FROM estados AS e
           INNER JOIN inventarios AS i on i.estado_id=e.id
           INNER JOIN municipios AS m on i.municipio_id=m.id
           INNER JOIN estatu_equipos AS h on h.id=i.estatu_equipo_id
           WHERE i.municipio_id = ? AND DATE(i.created_at) BETWEEN  ? AND ?
           GROUP BY e.estado, equipos_operativos, equipos_inoperativos
           ORDER BY e.estado", [$municipio_id, $fecha1, $fecha2] );
   
           echo json_encode($inventarios); // para pasar en json
       }


       public function ReporteInventarioGeneralCentroSaludGlobal($centro_salud_id, $fecha1, $fecha2)
       {
           $inventarios = DB::select("SELECT e.estado, m.municipio, c.centro_salud,
           (SELECT count(estatu_equipo_id) FROM inventarios WHERE estatu_equipo_id in (1) AND e.id=estado_id) AS equipos_operativos,
           (SELECT count(estatu_equipo_id) FROM inventarios WHERE estatu_equipo_id in (2) AND e.id=estado_id) AS equipos_baja_tecnicas,
           (SELECT count(estatu_equipo_id) FROM inventarios WHERE estatu_equipo_id in (3) AND e.id=estado_id) AS equipos_inoperativos,
           (SELECT count(estatu_equipo_id) FROM inventarios WHERE e.id=estado_id) AS total_equipos
          
           FROM estados AS e
           INNER JOIN inventarios AS i on i.estado_id=e.id
           INNER JOIN municipios AS m on i.municipio_id=m.id
           INNER JOIN centro_salud as c ON i.centro_salud_id = c.id
           INNER JOIN estatu_equipos AS h on h.id=i.estatu_equipo_id
           WHERE i.centro_salud_id = ? AND DATE(i.created_at) BETWEEN  ? AND ?
           GROUP BY e.estado, equipos_operativos, equipos_inoperativos
           ORDER BY e.estado", [$centro_salud_id, $fecha1, $fecha2] );
   
           echo json_encode($inventarios); // para pasar en json
       }


       // REPORTE GLOBAL POR CONDICION //


       public function ReporteInventarioGeneralCondicionGlobal($fecha1, $fecha2)
       {
           $inventarios = DB::select("SELECT DISTINCT e.estado,
           (SELECT count(reparado) FROM inventarios WHERE reparado in ('reparado') AND e.id=estado_id) AS reparados,
           (SELECT count(reparado) FROM inventarios WHERE reparado in ('instalado') AND e.id=estado_id) AS instalado,
           (SELECT count(reparado) FROM inventarios WHERE reparado = 'revision tecnica' AND e.id=estado_id) AS revision_tecnica,
           (SELECT count(reparado) FROM inventarios WHERE reparado in ('mantenimiento preventivo') AND e.id=estado_id) AS mantenimiento_preventivo,
         
           (SELECT count(estatu_equipo_id) FROM inventarios WHERE e.id=estado_id) AS total_equipos
           FROM estados AS e
           INNER JOIN inventarios AS i on i.estado_id=e.id
           INNER JOIN estatu_equipos AS h on h.id=i.estatu_equipo_id
           WHERE DATE(i.created_at) BETWEEN  ? AND ?
           GROUP BY e.estado, i.reparado
           ORDER BY e.estado", [$fecha1, $fecha2] );
   
           echo json_encode($inventarios); // para pasar en json
       }


       public function ReporteInventarioEstadalCondicionGlobal($estado_id, $fecha1, $fecha2)
       {
           $inventarios = DB::select("SELECT DISTINCT e.estado,
           (SELECT count(reparado) FROM inventarios WHERE reparado in ('reparado') AND e.id=estado_id) AS reparados,
           (SELECT count(reparado) FROM inventarios WHERE reparado in ('instalado') AND e.id=estado_id) AS instalado,
           (SELECT count(reparado) FROM inventarios WHERE reparado = 'revision tecnica' AND e.id=estado_id) AS revision_tecnica,
           (SELECT count(reparado) FROM inventarios WHERE reparado in ('mantenimiento preventivo') AND e.id=estado_id) AS mantenimiento_preventivo,
         
           (SELECT count(estatu_equipo_id) FROM inventarios WHERE e.id=estado_id) AS total_equipos
           FROM estados AS e
           INNER JOIN inventarios AS i on i.estado_id=e.id
           INNER JOIN estatu_equipos AS h on h.id=i.estatu_equipo_id
           WHERE i.estado_id = ? AND DATE(i.created_at) BETWEEN  ? AND ?
           GROUP BY e.estado, i.reparado
           ORDER BY e.estado", [$estado_id, $fecha1, $fecha2] );
   
           echo json_encode($inventarios); // para pasar en json
       }


       public function ReporteInventarioMunicipioCondicionGlobal($municipio_id, $fecha1, $fecha2)
       {
           $inventarios = DB::select("SELECT DISTINCT e.estado, m.municipio,
           (SELECT count(reparado) FROM inventarios WHERE reparado in ('reparado') AND e.id=estado_id) AS reparados,
           (SELECT count(reparado) FROM inventarios WHERE reparado in ('instalado') AND e.id=estado_id) AS instalado,
           (SELECT count(reparado) FROM inventarios WHERE reparado = 'revision tecnica' AND e.id=estado_id) AS revision_tecnica,
           (SELECT count(reparado) FROM inventarios WHERE reparado in ('mantenimiento preventivo') AND e.id=estado_id) AS mantenimiento_preventivo,
         
           (SELECT count(estatu_equipo_id) FROM inventarios WHERE e.id=estado_id) AS total_equipos
           FROM estados AS e
           INNER JOIN inventarios AS i on i.estado_id=e.id
           INNER JOIN estatu_equipos AS h on h.id=i.estatu_equipo_id
           INNER JOIN municipios AS m on i.municipio_id=m.id
           INNER JOIN centro_salud as c ON i.centro_salud_id = c.id
           WHERE i.municipio_id = ? AND DATE(i.created_at) BETWEEN  ? AND ?
           GROUP BY e.estado, i.reparado
           ORDER BY e.estado", [$municipio_id, $fecha1, $fecha2] );
   
           echo json_encode($inventarios); // para pasar en json
       }


       public function ReporteInventarioCentroSaludCondicionGlobal($centro_salud_id, $fecha1, $fecha2)
       {
           $inventarios = DB::select("SELECT DISTINCT e.estado, m.municipio, c.centro_salud,
           (SELECT count(reparado) FROM inventarios WHERE reparado in ('reparado') AND e.id=estado_id) AS reparados,
           (SELECT count(reparado) FROM inventarios WHERE reparado in ('instalado') AND e.id=estado_id) AS instalado,
           (SELECT count(reparado) FROM inventarios WHERE reparado = 'revision tecnica' AND e.id=estado_id) AS revision_tecnica,
           (SELECT count(reparado) FROM inventarios WHERE reparado in ('mantenimiento preventivo') AND e.id=estado_id) AS mantenimiento_preventivo,
         
           (SELECT count(estatu_equipo_id) FROM inventarios WHERE e.id=estado_id) AS total_equipos
           FROM estados AS e
           INNER JOIN inventarios AS i on i.estado_id=e.id
           INNER JOIN estatu_equipos AS h on h.id=i.estatu_equipo_id
           INNER JOIN municipios AS m on i.municipio_id=m.id
           INNER JOIN centro_salud as c ON i.centro_salud_id = c.id
           WHERE i.centro_salud_id = ? AND DATE(i.created_at) BETWEEN  ? AND ?
           GROUP BY e.estado, i.reparado
           ORDER BY e.estado", [$centro_salud_id, $fecha1, $fecha2] );
   
           echo json_encode($inventarios); // para pasar en json
       }




       public function ReporteInventarioGeneralEquiposGlobal($equipo_id,$fecha1, $fecha2)
       {
        //$equipo = '%'.$equipo.'%';
           $inventarios = DB::select("SELECT e.estado,
           (SELECT count(estatu_equipo_id) FROM inventarios WHERE estatu_equipo_id in (1) AND e.id=estado_id) AS equipos_operativos,
           (SELECT count(estatu_equipo_id) FROM inventarios WHERE estatu_equipo_id in (2) AND e.id=estado_id) AS equipos_baja_tecnicas,
           (SELECT count(estatu_equipo_id) FROM inventarios WHERE estatu_equipo_id in (3) AND e.id=estado_id) AS equipos_inoperativos,
           (SELECT count(estatu_equipo_id) FROM inventarios WHERE e.id=estado_id) AS total_equipos
          
           FROM estados AS e
           INNER JOIN inventarios AS i on i.estado_id=e.id
           INNER JOIN estatu_equipos AS h on h.id=i.estatu_equipo_id
           LEFT JOIN equipos ON i.equipo_id = equipos.id
           WHERE inventarios.equipo_id = ? AND DATE(i.created_at) BETWEEN ? AND ?
           GROUP BY e.estado, equipos_operativos, equipos_inoperativos
           ORDER BY e.estado", [ $equipo_id ,$fecha1, $fecha2] );
   
           echo json_encode($inventarios); // para pasar en json
       }


       public function ReporteInventarioEstadalEquiposGlobal($equipo_id, $estado_id ,$fecha1, $fecha2)
       {
        //$equipo = '%'.$equipo.'%';
           $inventarios = DB::select("SELECT e.estado,
           (SELECT count(estatu_equipo_id) FROM inventarios WHERE estatu_equipo_id in (1) AND e.id=estado_id) AS equipos_operativos,
           (SELECT count(estatu_equipo_id) FROM inventarios WHERE estatu_equipo_id in (2) AND e.id=estado_id) AS equipos_baja_tecnicas,
           (SELECT count(estatu_equipo_id) FROM inventarios WHERE estatu_equipo_id in (3) AND e.id=estado_id) AS equipos_inoperativos,
           (SELECT count(estatu_equipo_id) FROM inventarios WHERE e.id=estado_id) AS total_equipos
          
           FROM estados AS e
           INNER JOIN inventarios AS i on i.estado_id=e.id
           INNER JOIN estatu_equipos AS h on h.id=i.estatu_equipo_id
           LEFT JOIN equipos ON i.equipo_id = equipos.id
           WHERE inventarios.equipo_id = ? AND i.estado_id = ?  AND DATE(i.created_at) BETWEEN ? AND ?
           GROUP BY e.estado, equipos_operativos, equipos_inoperativos
           ORDER BY e.estado", [ $equipo_id ,$estado_id ,$fecha1, $fecha2] );
   
           echo json_encode($inventarios); // para pasar en json
       }


       public function ReporteInventarioMunicipiosEquiposGlobal($equipo_id, $municipio_id ,$fecha1, $fecha2)
       {
        //$equipo = '%'.$equipo.'%';
           $inventarios = DB::select("SELECT e.estado, m.municipio,
           (SELECT count(estatu_equipo_id) FROM inventarios WHERE estatu_equipo_id in (1) AND e.id=estado_id) AS equipos_operativos,
           (SELECT count(estatu_equipo_id) FROM inventarios WHERE estatu_equipo_id in (2) AND e.id=estado_id) AS equipos_baja_tecnicas,
           (SELECT count(estatu_equipo_id) FROM inventarios WHERE estatu_equipo_id in (3) AND e.id=estado_id) AS equipos_inoperativos,
           (SELECT count(estatu_equipo_id) FROM inventarios WHERE e.id=estado_id) AS total_equipos
          
           FROM estados AS e
           INNER JOIN inventarios AS i on i.estado_id=e.id
           INNER JOIN estatu_equipos AS h on h.id=i.estatu_equipo_id
           LEFT JOIN equipos ON i.equipo_id = equipos.id
           INNER JOIN municipios AS m on i.municipio_id=m.id
           INNER JOIN centro_salud as c ON i.centro_salud_id = c.id
           WHERE inventarios.equipo_id = ? AND i.municipio_id = ?  AND DATE(i.created_at) BETWEEN ? AND ?
           GROUP BY e.estado, equipos_operativos, equipos_inoperativos
           ORDER BY e.estado", [ $equipo_id ,$municipio_id ,$fecha1, $fecha2] );
   
           echo json_encode($inventarios); // para pasar en json
       }

       public function ReporteInventarioCentroSaludEquiposGlobal($equipo_id, $centro_salud_id ,$fecha1, $fecha2)
       {
        //$equipo = '%'.$equipo.'%';
           $inventarios = DB::select("SELECT e.estado, m.municipio, c.centro_salud,
           (SELECT count(estatu_equipo_id) FROM inventarios WHERE estatu_equipo_id in (1) AND e.id=estado_id) AS equipos_operativos,
           (SELECT count(estatu_equipo_id) FROM inventarios WHERE estatu_equipo_id in (2) AND e.id=estado_id) AS equipos_baja_tecnicas,
           (SELECT count(estatu_equipo_id) FROM inventarios WHERE estatu_equipo_id in (3) AND e.id=estado_id) AS equipos_inoperativos,
           (SELECT count(estatu_equipo_id) FROM inventarios WHERE e.id=estado_id) AS total_equipos
          
           FROM estados AS e
           INNER JOIN inventarios AS i on i.estado_id=e.id
           INNER JOIN estatu_equipos AS h on h.id=i.estatu_equipo_id
           LEFT JOIN equipos ON i.equipo_id = equipos.id
           INNER JOIN municipios AS m on i.municipio_id=m.id
           INNER JOIN centro_salud as c ON i.centro_salud_id = c.id
           WHERE inventarios.equipo_id = ? AND i.centro_salud_id = ? AND DATE(i.created_at) BETWEEN ? AND ?
           GROUP BY e.estado, equipos_operativos, equipos_inoperativos
           ORDER BY e.estado", [ $equipo_id ,$centro_salud_id ,$fecha1, $fecha2] );
   
           echo json_encode($inventarios); // para pasar en json
       }






}
