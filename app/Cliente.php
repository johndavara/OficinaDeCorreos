<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    //
    protected $table = "clientes";
    protected $primaryKey = "id";
    public $timestamps = true;
    protected $fillable = ['id','zona','calle','avenida','pisos','distancia','cantidad','latitud','longitud',
    'razonSocial','nombre','telefono','observacion','created_at','updated_at'];
}
