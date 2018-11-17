<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Repartidor extends Model
{
    protected $table = "repartidor";

    protected $primaryKey = "id";

    public $timestamps = true;

    protected $fillable = [
        'id',
        'nombre',
        'cedula',
        'telefono',
        'idusuario',
        'created_at',
        'updated_at',
    ];
}
