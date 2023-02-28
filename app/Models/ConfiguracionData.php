<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfiguracionData extends Model
{
    use HasFactory;
    protected $table = "configuracion_data"; 
    public $timestamps = false;
}
