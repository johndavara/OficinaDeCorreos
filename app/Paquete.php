<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paquete extends Model
{
    protected $table = "paquete";
    protected $primaryKey = "id";
    public $timestamps = true;
    protected $fillable = ['id','identificador',
    'descripcion','remitente','destinatario','zona','direccion','peso','idestado','montoACancelar','created_at','updated_at','idoficina'];
}
