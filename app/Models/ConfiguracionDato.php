<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfiguracionDato extends Model
{
    use HasFactory;
    protected $table = "configuracion_dato"; 
    public $timestamps = false;
}
