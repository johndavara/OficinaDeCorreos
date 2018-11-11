<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Oficina extends Model
{
    //
    protected $table = "oficina";
    protected $primaryKey = "id";
    public $timestamps = true;
    protected $fillable = ['id','supervisor','telefono','nombreOficina','zona','created_at','updated_at'];
}
