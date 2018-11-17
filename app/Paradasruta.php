<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paradasruta extends Model
{
    protected $table = "paradasruta";

    protected $primaryKey = "id";

    public $timestamps = true;

    protected $fillable = [
        'id',
        'oficinadesde',
        'oficinahasta',
        'paquete',
        'ruta',
        'created_at',
        'updated_at',
        'idRepartidor',
        'nombre'
    ];
}
