<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ruta extends Model
{
    protected $table = "ruta";

    protected $primaryKey = "id";

    public $timestamps = true;

    protected $fillable = [
        'id',
        'tipo',
        'descripcion',
        'created_at',
        'updated_at'
    ];
}
