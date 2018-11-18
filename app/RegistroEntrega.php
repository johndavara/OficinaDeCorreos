<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistroEntrega extends Model
{
    protected $table = "registro_entrega";

    protected $primaryKey = "id";

    public $timestamps = true;

    protected $fillable = [
        'id',
        'descripcion',
        'identificadorPaquete',
        'idPaquete',
        'idRepartidor',
        'created_at',
        'updated_at'
    ];
}
