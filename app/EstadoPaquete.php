<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoPaquete extends Model
{
    //
    protected $table = "estadopaquete";
    protected $primaryKey = "id";
    public $timestamps = true;
    protected $fillable = ['id','descripcion','created_at','updated_at'];
}
