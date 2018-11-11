<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if($buscar == ''){
            $clientes =  Cliente::orderBy('id','desc')->paginate(5);
        }else{
            $clientes =  Cliente::where($criterio,'like','%'.$buscar.'%')->orderBy('id','desc')->paginate(5);
        }
        return [
            'pagination'=>[
                'total'=>$clientes->total(),
                'current_page'=>$clientes->currentPage(),
                'per_page'=>$clientes->perPage(),
                'last_page'=>$clientes->lastPage(),
                'from'=>$clientes->firstItem(),
                'to'=>$clientes->lastItem(),
            ],
            'clientes'=>$clientes
        ];
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
        if(!$request->ajax()) return redirect('/');
        $cliente = new Cliente();
        $cliente->zona = $request->zona;
        $cliente->nombre = $request->nombre;
        $cliente->avenida = $request->avenida;
        $cliente->calle = $request->calle;
        $cliente->pisos = $request->pisos;
        $cliente->distancia = $request->distancia;
        $cliente->cantidad = $request->cantidad;
        $cliente->latitud = $request->latitud;
        $cliente->longitud = $request->longitud;
        $cliente->razonSocial = $request->razonSocial;
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
        if(!$request->ajax()) return redirect('/');
        $cliente = Cliente::findOrFail($request->id);
        $cliente->zona = $request->zona;
        $cliente->nombre = $request->nombre;
        $cliente->avenida = $request->avenida;
        $cliente->pisos = $request->pisos;
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
    public function destroy(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        Cliente::destroy($request->id);
    }
}
