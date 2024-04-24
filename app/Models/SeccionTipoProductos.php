<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeccionTipoProductos extends Model
{
    use HasFactory;
    protected $table = "seccion_tipo_productos"; 
    public $timestamps = false;
}
