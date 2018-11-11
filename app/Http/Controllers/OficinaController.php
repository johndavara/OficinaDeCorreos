<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Oficina;
use App\Zona;
use Illuminate\Support\Facades\DB;

class OficinaController extends Controller
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
        $zonas = Zona::orderBy('nombre')->get();
        if($buscar == ''){
            $oficinas =  Oficina::join('zona', 'oficina.zona', '=', 'zona.id')
            ->select('zona.nombre as zona', 'zona.id as zonaid', 'oficina.id','oficina.supervisor','oficina.nombreOficina','oficina.telefono')
            ->orderBy('id','desc')
            ->paginate(5);
        }else{
            if($criterio == 'zona'){
                $oficinas =  Oficina::join('zona', 'oficina.zona', '=', 'zona.id')
                ->where('zona.nombre','like','%'.$buscar.'%')
                ->select('zona.nombre as zona', 'zona.id as zonaid','oficina.id', 'oficina.supervisor','oficina.nombreOficina','oficina.telefono')
                ->orderBy('id','desc')
                ->paginate(5);
            }else{
                 $oficinas =  Oficina::join('zona', 'oficina.zona', '=', 'zona.id')
                 ->where($criterio,'like','%'.$buscar.'%')
                 ->select('zona.nombre as zona', 'zona.id as zonaid','oficina.id', 'oficina.supervisor','oficina.nombreOficina','oficina.telefono')
                 ->orderBy('id','desc')
                 ->paginate(5);
            }
        }
        return [
            'pagination'=>[
                'total'=>$oficinas->total(),
                'current_page'=>$oficinas->currentPage(),
                'per_page'=>$oficinas->perPage(),
                'last_page'=>$oficinas->lastPage(),
                'from'=>$oficinas->firstItem(),
                'to'=>$oficinas->lastItem(),
            ],
            'oficinas'=>$oficinas,
            'zonas'=>$zonas
        ];
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
        $cliente = new Oficina();
        $cliente->zona = $request->zonaid;
        $cliente->supervisor = $request->supervisor;
        $cliente->nombreOficina = $request->nombreOficina;
        $cliente->telefono = $request->telefono;
        $cliente->save();
        
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
        $cliente = Oficina::findOrFail($request->id);
        $cliente->zona = $request->zonaid;
        $cliente->supervisor = $request->supervisor;
        $cliente->nombreOficina = $request->nombreOficina;
        $cliente->telefono = $request->telefono;
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
        Oficina::destroy($request->id);
    }
}
