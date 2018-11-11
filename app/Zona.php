<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zona extends Model
{
    protected $table = "zona";
    protected $primaryKey = "id";
    public $timestamps = true;
    protected $fillable = ['id','nombre'];
}
