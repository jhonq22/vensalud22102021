<?php

namespace App\Http\Controllers;

use App\EstatuSolicitudRepuestos;
use Illuminate\Http\Request;

class EstatuSolicitudRepuestosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estatu =EstatuSolicitudRepuestos::get();
        echo json_encode($estatu);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EstatuSolicitudRepuestos  $estatuSolicitudRepuestos
     * @return \Illuminate\Http\Response
     */
    public function show(EstatuSolicitudRepuestos $estatuSolicitudRepuestos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EstatuSolicitudRepuestos  $estatuSolicitudRepuestos
     * @return \Illuminate\Http\Response
     */
    public function edit(EstatuSolicitudRepuestos $estatuSolicitudRepuestos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EstatuSolicitudRepuestos  $estatuSolicitudRepuestos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EstatuSolicitudRepuestos $estatuSolicitudRepuestos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EstatuSolicitudRepuestos  $estatuSolicitudRepuestos
     * @return \Illuminate\Http\Response
     */
    public function destroy(EstatuSolicitudRepuestos $estatuSolicitudRepuestos)
    {
        //
    }
}
