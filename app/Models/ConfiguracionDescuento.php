<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfiguracionDescuento extends Model
{
    use HasFactory;
    protected $table = "configuracion_descuento"; 
    public $timestamps = false;
}
