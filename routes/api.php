<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


//Users
Route::post('register', 'UserController@register');
Route::post('login', 'UserController@login');
Route::get('profile', 'UserController@getAuthenticatedUser');
Route::put('usuarios_subir_foto/{$user_id}', 'UserController@ActualizarFoto');




//CRUD USERS
Route::resource('usuarios', 'UserController');
Route::resource('tecnicos', 'TecnicosController');


// Equipos 
Route::resource('equipos', 'EquipoController');

Route::resource('estatus_solicitud_repuestos', 'EstatuSolicitudRepuestosController');
Route::put('estatu_repuestos_actualizar/{$estatu_id}', 'EstatuSolicitudRepuestosController@ActualizarFoto');


//CRUD Multimedia Inventario
Route::resource('multimedia_inventario', 'MultimediaInventarioController');

Route::get('multimedia_inventario/galeria/{inventario_id}', 
	'MultimediaInventarioController@InventarioGaleriaFotos');



Route::resource('historico_estatus', 'HistoricoEstatuController');
Route::get('historico_estatu_equipo/{historico_id}', 'HistoricoEstatuController@VerHistoricoEstatus');


// COMBO LIST
Route::resource('estados','EstadoController');
Route::resource('municipios','MunicipioController');
Route::resource('entes',      'EnteController');
//  CENTRO SALUD
Route::resource('centro_salud', 'CentroSaludController');
Route::get('centro_salud_list', 'CentroSaludController@centrosaludList');
Route::get('centro_salud_estados/{estado_id}', 'CentroSaludController@centrosaludListEstados');
//  CENTRO SALUD

//blibioteca virtual 
Route::resource('biblioteca_virtual', 'BibliotecaVirtualController');


Route::resource('estatus_equipos', 'EstatuEquipoController');

Route::resource('marcas', 'MarcaController');

Route::resource('equipos_respuestos', 'EquiposRespuestoController');

// DETALLES REPUESTO //
Route::resource('detalle_respuesto', 'DetalleRespuestoController');
Route::get('detalle_respuesto_inventario/{inventario_id}','DetalleRespuestoController@detallesMisRespuestosInventarios');
Route::get('respuesto/solicitados', 'DetalleRespuestoController@ListadoRespuestosSolicitados');
// REPORTE
Route::get('detalle_respuesto_inventario/reporte/estadal/{estado_id}','DetalleRespuestoController@ReporteEstadalMisRespuestosInventarios');




//  INVENTARIO
Route::resource('inventarios', 'InventarioController');
Route::get('inventarios/detallado/{inventario_id}','InventarioController@InventarioDetallada');

// EQUIPOS NO OPERATIVOS ESTADAL 
Route::get('inventario/no','InventarioController@equiposno');
Route::get('inventario/no/{estado_id}','InventarioController@equiposnoEstadal');



//INVENTARIO LISTADO POR ESTADOS
Route::get('inventarios/estados/{inventario_id}','InventarioController@InventarioPorEstados');

//INVENTARIO LISTADO POR MUNICIPIOS
Route::get('inventarios/municipios/{inventario_id}','InventarioController@InventarioPorMunicipio');
//INVENTARIO LISTADO POR CENTRO DE SALUD

Route::get('inventarios/centrosalud/{inventario_id}','InventarioController@InventarioPorCentroSalud');

// VERIFICAR SI EXISTE LA MARCA
Route::get('inventarios/marca/{marca_id}/{serial}','InventarioController@inventarioMarcaDuplicado');

// TABLAS EQUIPOS
Route::get('inventario/tabla','InventarioController@TablaEquipos');
Route::get('inventario/tabla/general','InventarioController@CoeficienteGeneralEquipos');



//ESTADISTICA //
Route::get('inventario/contar_equipos', 'InventarioController@EstatusEquiposInventariosContar');




Route::get('inventario/contar_equipos/estados/{inventario_id}', 'InventarioController@EstatusEquiposInventariosContarEstados');



Route::get('inventario/contar_equipos/centrosalud/{inventario_id}', 'InventarioController@EstatusEquiposInventariosContarCentroSalud');


Route::get('inventario/total/estados/{inventario_id}', 'InventarioController@totalInventarioPorEstados');

Route::get('inventario/total/centrosalud/{inventario_id}', 'InventarioController@totalInventarioPorCentroSalud');
Route::get('inventario/total', 'InventarioController@totalInventario');

Route::get('users/total_usuarios', 'UserController@totalUsuarios');






// REPORTES INVENTARIOS POR ESTADOS //


Route::get('inventario/reportes/general/{fecha1}/{fecha2}/{fecha3}/{fecha4}', 'InventarioController@ReporteInventarioGeneral');

Route::get('inventario/reportes/estadal/{fecha1}/{fecha2}/{estado_id1}/{estado_id2}/{fecha3}/{fecha4}', 'InventarioController@ReporteInventarioEstadal');


Route::get('inventario/reportes/municipal/{fecha1}/{fecha2}/{municipio_id1}/{municipio_id2}/{fecha3}/{fecha4}', 'InventarioController@ReporteInventarioMunicipal');


Route::get('inventario/reportes/centro_salud/{fecha1}/{fecha2}/{centro_salud1}/{centro_salud2}/{fecha3}/{fecha4}', 'InventarioController@ReporteInventarioCentroSalud');


// REPORTES INVENTARIOS POR ESTADOS Y ESTATUS //

Route::get('inventario/reportes/general/estatus/{equipo_id}/{estatu_equipo_id}/{fecha1}/{fecha2}/{fecha3}/{fecha4}', 'InventarioController@ReporteInventarioGeneralPorEstatus');


Route::get('inventario/reportes/estadal/estatus/{equipo_id}/{estado_id}/{estatu_equipo_id}/{fecha1}/{fecha2}/{fecha3}/{fecha4}', 'InventarioController@ReporteInventarioEstadalPorEstatus');

Route::get('inventario/reportes/municipal/estatus/{equipo_id}/{municipio_id}/{estatu_equipo_id}/{fecha1}/{fecha2}/{fecha3}/{fecha4}', 'InventarioController@ReporteInventarioMunicipalPorEstatus');

Route::get('inventario/reportes/centro_salud/estatus/{equipo_id}/{centro_salud_id}/{estatu_equipo_id}/{fecha1}/{fecha2}/{fecha3}/{fecha4}', 'InventarioController@ReporteInventarioCentroSaludPorEstatus');





// REPORTES INVENTARIOS POR ESTADOS Y REPARADOS //



Route::get('inventario/reportes/estadal/reparado/{equipo_id}/{estado_id}/{reparado}/{fecha1}/{fecha2}', 'InventarioController@ReporteInventarioEstadalPorReparados');

Route::get('inventario/reportes/municipal/reparado/{equipo_id}/{municipio_id}/{reparado}/{fecha1}/{fecha2}', 'InventarioController@ReporteInventarioMunicipalPorReparados');

Route::get('inventario/reportes/centro_salud/reparado/{equipo_id}/{centro_salud_id}/{reparado}/{fecha1}/{fecha2}', 'InventarioController@ReporteInventarioCentroSaludPorReparados');







// Reportes para buscar equipos con el input 
Route::get('inventario/reportes/buscar_equipo/{equipo_id}/{fecha1}/{fecha2}', 'InventarioController@ReporteInventarioBuscarEquipo');
Route::get('inventario/reportes/buscar_equipo/estados/{equipo_id}/{estado_id}/{fecha1}/{fecha2}', 'InventarioController@ReporteInventarioBuscarEquipoEstados');
Route::get('inventario/reportes/buscar_equipo/municipios/{equipo_id}/{municipio_id}/{fecha1}/{fecha2}', 'InventarioController@ReporteInventarioBuscarEquipoMunicipios');
Route::get('inventario/reportes/buscar_equipo/centro_salud/{equipo_id}/{centro_salud_id}/{fecha1}/{fecha2}', 'InventarioController@ReporteInventarioBuscarEquipoCentroSalud');





Route::resource('historico_inventario', 'HistoricoInventarioController');
// INVENTARIO







// REPORTES INVENTARIOS GENERAL  GLOBAL //


Route::get('inventario/reportes/general/global/{fecha1}/{fecha2}', 'InventarioController@ReporteInventarioGeneralGlobal');

Route::get('inventario/reportes/estadal/global/{estado_id}/{fecha1}/{fecha2}', 'InventarioController@ReporteInventarioGeneralEstadalGlobal');


Route::get('inventario/reportes/municipal/global/{municipio_id}/{fecha1}/{fecha2}', 'InventarioController@ReporteInventarioGeneralMunicipalGlobal');


Route::get('inventario/reportes/centro_salud/global/{centro_salud_id}/{fecha1}/{fecha2}', 'InventarioController@ReporteInventarioGeneralCentroSaludGlobal');





// REPORTES INVENTARIOS POR CONDICION  GLOBAL //


Route::get('inventario/reportes/condicion/general/global/{fecha1}/{fecha2}', 'InventarioController@ReporteInventarioGeneralCondicionGlobal');

Route::get('inventario/reportes/condicion/estadal/global/{estado_id}/{fecha1}/{fecha2}', 'InventarioController@ReporteInventarioEstadalCondicionGlobal');

Route::get('inventario/reportes/condicion/municipal/global/{municipio_id}/{fecha1}/{fecha2}', 'InventarioController@ReporteInventarioMunicipioCondicionGlobal');

Route::get('inventario/reportes/condicion/centro_salud/global/{centro_salud_id}/{fecha1}/{fecha2}', 'InventarioController@ReporteInventarioCentroSaludCondicionGlobal');






// REPORTES INVENTARIOS POR EQUIPO  GLOBAL //


Route::get('inventario/reportes/equipos/general/global/{equipo}/{fecha1}/{fecha2}', 'InventarioController@ReporteInventarioGeneralEquiposGlobal');

Route::get('inventario/reportes/equipos/estadal/global/{equipo}/{estado_id}/{fecha1}/{fecha2}', 'InventarioController@ReporteInventarioEstadalEquiposGlobal');

Route::get('inventario/reportes/equipos/municipal/global/{equipo}/{municipio_id}/{fecha1}/{fecha2}', 'InventarioController@ReporteInventarioMunicipiosEquiposGlobal');

Route::get('inventario/reportes/equipos/centro_salud/global/{equipo}/{centro_salud}/{fecha1}/{fecha2}', 'InventarioController@ReporteInventarioCentroSaludEquiposGlobal');







Route::get('marcas/registradas/{marca}', 'MarcaController@marcasRegistrada');
Route::get('equipos/registradas/{equipo}', 'EquipoController@equiposRegistrada');
Route::get('centros/registradas/{centro}', 'CentroSaludController@centroRegistrada');



// importar excel
Route::post('import', 'InventarioController@import')->name('import');