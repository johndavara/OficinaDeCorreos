<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Zona;
use App\EstadoPaquete;
use App\Oficina;
use App\Paquete;
use App\Repartidor;
use App\RegistroEntrega;
use App\Paradasruta;
use Illuminate\Support\Facades\DB;
class PaqueteController extends Controller
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
        $oficinas = Oficina::orderBy('nombreOficina')->get();
        $estados = EstadoPaquete::orderBy('descripcion')->get();
        $repartidores = Repartidor::all();
        if($buscar == ''){
            $paquetes =  Paquete::join('zona', 'paquete.zona', '=', 'zona.id')
            ->select('zona.nombre as zona',
            'zona.id as zonaid', 
            'paquete.id',
            'paquete.remitente',
            'paquete.destinatario',
            'paquete.peso',
            'paquete.direccion',
            'paquete.descripcion',
            'paquete.montoACancelar',
            'paquete.idoficina',
            'paquete.identificador',
            'paquete.idestado')
            ->orderBy('id','desc')
            ->paginate(5);
        }else{
            if($criterio == 'zona'){
                $paquetes =  Paquete::join('zona', 'paquete.zona', '=', 'zona.id')
                ->where('zona.nombre','like','%'.$buscar.'%')
                ->select('zona.nombre as zona',
                'zona.id as zonaid', 
                'paquete.id',
                'paquete.remitente',
                'paquete.destinatario',
                'paquete.peso',
                'paquete.direccion',
                'paquete.descripcion',
                'paquete.montoACancelar',
                'paquete.idoficina',
                'paquete.identificador',
                'paquete.idestado')
                ->orderBy('id','desc')
                ->paginate(5);
            }else{
                if($criterio == 'remitente'){
                    $paquetes =  Paquete::join('zona', 'paquete.zona', '=', 'zona.id')
                    ->where('paquete.remitente','like','%'.$buscar.'%')
                    ->select('zona.nombre as zona',
                    'zona.id as zonaid', 
                    'paquete.id',
                    'paquete.remitente',
                    'paquete.destinatario',
                    'paquete.peso',
                    'paquete.direccion',
                    'paquete.descripcion',
                    'paquete.montoACancelar',
                    'paquete.idoficina',
                    'paquete.identificador',
                    'paquete.idestado')
                    ->orderBy('id','desc')
                    ->paginate(5);
                }else{
                    if($criterio == 'destinatario'){
                        $paquetes =  Paquete::join('zona', 'paquete.zona', '=', 'zona.id')
                        ->where('paquete.destinatario','like','%'.$buscar.'%')           
                         ->select('zona.nombre as zona',
                        'zona.id as zonaid', 
                        'paquete.id',
                        'paquete.remitente',
                        'paquete.destinatario',
                        'paquete.peso',
                        'paquete.direccion',
                        'paquete.descripcion',
                        'paquete.montoACancelar',
                        'paquete.idoficina',
                        'paquete.identificador',
                        'paquete.idestado')
                        ->orderBy('id','desc')
                        ->paginate(5);
                    }else{
                        if($criterio == 'identificador'){
                            $paquetes =  Paquete::join('zona', 'paquete.zona', '=', 'zona.id')
                            ->where('paquete.identificador','like','%'.$buscar.'%')
                            ->select('zona.nombre as zona',
                            'zona.id as zonaid', 
                            'paquete.id',
                            'paquete.remitente',
                            'paquete.destinatario',
                            'paquete.peso',
                            'paquete.direccion',
                            'paquete.descripcion',
                            'paquete.montoACancelar',
                            'paquete.idoficina',
                            'paquete.identificador',
                            'paquete.idestado')
                            ->orderBy('id','desc')
                            ->paginate(5);
                        }else{
                            $paquetes =  Oficina::join('zona', 'oficina.zona', '=', 'zona.id')
                            ->where($criterio,'like','%'.$buscar.'%')
                            ->select('zona.nombre as zona',
                            'zona.id as zonaid', 
                            'paquete.id',
                            'paquete.remitente',
                            'paquete.destinatario',
                            'paquete.peso',
                            'paquete.direccion',
                            'paquete.descripcion',
                            'paquete.montoACancelar',
                            'paquete.idoficina',
                            'paquete.identificador',
                            'paquete.idestado')
                            ->orderBy('id','desc')
                            ->paginate(5);
                        }
                    }
                }
            }
        }
        return [
            'pagination'=>[
                'total'=>$paquetes->total(),
                'current_page'=>$paquetes->currentPage(),
                'per_page'=>$paquetes->perPage(),
                'last_page'=>$paquetes->lastPage(),
                'from'=>$paquetes->firstItem(),
                'to'=>$paquetes->lastItem(),
            ],
            'paquetes'=>$paquetes,
            'oficinas'=>$oficinas,
            'zonas'=>$zonas,
            'estados'=>$estados,
            'repartidores' => $repartidores,
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
        $paquete = new Paquete();
        $paquete->zona = $request->idzona;
        $paquete->remitente = $request->remitente;
        $paquete->destinatario = $request->destinatario;
        $paquete->peso = $request->peso;
        $paquete->montoACancelar = $request->montoACancelar;
        $paquete->idestado = $request->idestado;
        $paquete->idoficina = $request->idoficina;
        $paquete->descripcion = $request->descripcion;
        $paquete->identificador = $request->identificador;
        $paquete->direccion = $request->direccion;
        $paquete->save();
        
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
        $paquete = Paquete::findOrFail($request->id);
        $paquete->zona = $request->idzona;
        $paquete->remitente = $request->remitente;
        $paquete->destinatario = $request->destinatario;
        $paquete->peso = $request->peso;
        $paquete->montoACancelar = $request->montoACancelar;
        $paquete->idestado = $request->idestado;
        $paquete->idoficina = $request->idoficina;
        $paquete->descripcion = $request->descripcion;
        $paquete->identificador = $request->identificador;
        $paquete->direccion = $request->direccion;
        $paquete->save();
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
        Paquete::destroy($request->id);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function packageHistory(Request $request)
    { 
        if(!$request->ajax()) return redirect('/');
        $idPaquete =  $request->id;
        $historial = 
        Paquete::
        join('registro_entrega', 'paquete.id', '=', 'registro_entrega.idPaquete')->
        join('repartidor', 'registro_entrega.idRepartidor', '=', 'repartidor.id')->
        where('paquete.id','=',$idPaquete)->
        select('registro_entrega.id','repartidor.nombre','registro_entrega.created_at as fecha','registro_entrega.descripcion')
        ->get();
   
        return ['historial'=>$historial];
    }

        /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyHistorial(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        RegistroEntrega::destroy($request->id);
    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeHistorial(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');
        $registroEntrega = new RegistroEntrega();
        $registroEntrega->descripcion = $request->descripcion;
        $registroEntrega->identificadorPaquete = $request->identificadorPaquete;
        $registroEntrega->idPaquete = $request->idPaquete;
        $registroEntrega->idRepartidor = $request->idRepartidor;
       // $registroEntrega->created_at = $request->fecha;
        $registroEntrega->save();
        
    }
}
