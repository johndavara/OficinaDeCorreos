<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = Cliente::all();
        return $clientes;
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
        $cliente = new Cliente();
        $cliente->zona = $request->zona;
        $cliente->nombre = $request->nombre;
        $cliente->avenida = $request->avenida;
        $cliente->distancia = $request->distancia;
        $cliente->cantidad = $request->cantidad;
        $cliente->latitud = $request->longitud;
        $cliente->razonSocial = $request->razonSocial;
        $cliente->nombre = $request->nombre;
        $cliente->telefono = $request->telefono;
        $cliente->observacion = $request->observacion;
        $cliente->save();
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $cliente = new Cliente::findOrFail($request->id);
        $cliente->zona = $request->zona;
        $cliente->nombre = $request->nombre;
        $cliente->avenida = $request->avenida;
        $cliente->distancia = $request->distancia;
        $cliente->cantidad = $request->cantidad;
        $cliente->latitud = $request->longitud;
        $cliente->razonSocial = $request->razonSocial;
        $cliente->nombre = $request->nombre;
        $cliente->telefono = $request->telefono;
        $cliente->observacion = $request->observacion;
        $cliente->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($request)
    {
        Cliente::destroy($request->id);
    }
}
