<?php

namespace App\Http\Controllers;

use App\Oficina;
use App\Paquete;
use App\Paradasruta;
use App\Repartidor;
use App\Ruta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
class RutaController extends Controller
{
    /**
     * @param Request $request
     * @return array|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $userId = Auth::user()->id;
        $repartidor = Repartidor::where('idusuario','=',$userId)->get();
        
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if(  $repartidor!=null && count($repartidor) > 0){
        $rutas =
            Paradasruta::
            join('paquete', 'paradasruta.paquete', '=', 'paquete.id')->
            join('ruta', 'paradasruta.ruta', '=', 'ruta.id')->
            join('repartidor', 'paradasruta.idRepartidor', '=', 'repartidor.id')->
            join('oficina as desde', 'paradasruta.oficinadesde', '=', 'desde.id')->
            join('oficina as hasta', 'paradasruta.oficinahasta', '=', 'hasta.id')->
            join('estadopaquete', 'paquete.idestado', '=', 'estadopaquete.id')->
            where('repartidor.id','=',$repartidor[0]->id)->
            select(
                'estadopaquete.descripcion as paqueteEstado',
                'paquete.identificador as paqueteIdentificador',
                'paquete.descripcion as paqueteDescripcion',
                'paquete.id as paqueteId',

                'ruta.id as rutaId',
                'ruta.tipo as rutaTipo',
                'ruta.descripcion as rutaDescripcion',

                'repartidor.id as repartidorId',
                'repartidor.nombre as repartidorNombre',

                'desde.nombreOficina as desdeNombre',
                'desde.id as desdeId',

                'hasta.nombreOficina as hastaNombre',
                'hasta.id as hastaId',

                'paradasruta.id',
                'paradasruta.nombre'
            );
        }else{

            $rutas =
            Paradasruta::
            join('paquete', 'paradasruta.paquete', '=', 'paquete.id')->
            join('ruta', 'paradasruta.ruta', '=', 'ruta.id')->
            join('repartidor', 'paradasruta.idRepartidor', '=', 'repartidor.id')->
            join('oficina as desde', 'paradasruta.oficinadesde', '=', 'desde.id')->
            join('oficina as hasta', 'paradasruta.oficinahasta', '=', 'hasta.id')->
            join('estadopaquete', 'paquete.idestado', '=', 'estadopaquete.id')->
            select(
                'estadopaquete.descripcion as paqueteEstado',
                'paquete.identificador as paqueteIdentificador',
                'paquete.descripcion as paqueteDescripcion',
                'paquete.id as paqueteId',

                'ruta.id as rutaId',
                'ruta.tipo as rutaTipo',
                'ruta.descripcion as rutaDescripcion',

                'repartidor.id as repartidorId',
                'repartidor.nombre as repartidorNombre',

                'desde.nombreOficina as desdeNombre',
                'desde.id as desdeId',

                'hasta.nombreOficina as hastaNombre',
                'hasta.id as hastaId',

                'paradasruta.id',
                'paradasruta.nombre'
            );

        }


        if ($criterio == 'encargado') {
            $rutas = $rutas->where('repartidor.nombre', 'like', '%' . $buscar . '%');
        } else {
            if ($criterio == 'idpaquete') {
                $rutas = $rutas->where('paquete.identificador', 'like', '%' . $buscar . '%');
            } else {
                if ($criterio == 'nombrepaquete') {
                    $rutas = $rutas->where('paquete.descripcion', 'like', '%' . $buscar . '%');
                }
            }
        }

        $rutas = $rutas
            ->orderBy('paradasruta.id', 'desc')
            ->paginate(5);

        $repartidores = Repartidor::all();
        $tiposRutas = Ruta::all();
        $paquetes = Paquete::all();
        $oficinas = Oficina::all();

        $rutaSola = Paradasruta::
        join('ruta', 'paradasruta.ruta', '=', 'ruta.id')->
        join('repartidor', 'paradasruta.idRepartidor', '=', 'repartidor.id')->
        select(
            'ruta.id as rutaId',
            'ruta.tipo as rutaTipo',
            'ruta.descripcion as rutaDescripcion',

            'repartidor.id as repartidorId',
            'repartidor.nombre as repartidorNombre',

            'paradasruta.id',
            'paradasruta.nombre'
        )
            ->whereNull('paradasruta.paquete')
            ->orderBy('paradasruta.id', 'desc')->paginate(100);

        return [
            'pagination' => [
                'total' => $rutas->total(),
                'current_page' => $rutas->currentPage(),
                'per_page' => $rutas->perPage(),
                'last_page' => $rutas->lastPage(),
                'from' => $rutas->firstItem(),
                'to' => $rutas->lastItem(),
            ],
            'rutas' => $rutas,
            'repartidores' => $repartidores,
            'rutasTipos' => $tiposRutas,
            'rutaSola' => $rutaSola,
            'paquetes' => $paquetes,
            'oficinas' => $oficinas
        ];

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if (!$request->ajax()) return redirect('/');
        $paradasruta = new Paradasruta();
        $paradasruta->ruta = $request->tiporuta;
        $paradasruta->idRepartidor = $request->repartidorid;
        $paradasruta->nombre = $request->ruta;
        $paradasruta->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $paradasruta = Paradasruta::findOrFail($request->id);
        $paradasruta->ruta = $request->tiporuta;
        $paradasruta->idRepartidor = $request->repartidorid;
        $paradasruta->nombre = $request->ruta;
        $paradasruta->save();
    }

    public function updatePaquete(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $paradasruta = Paradasruta::findOrFail($request->ruta);
        $paradasruta->oficinadesde = $request->desde;
        $paradasruta->oficinahasta = $request->hasta;
        $paradasruta->paquete = $request->paquete;
        $paradasruta->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        Paradasruta::destroy($request->id);
    }
}
