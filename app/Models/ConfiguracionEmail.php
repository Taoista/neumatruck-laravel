<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfiguracionEmail extends Model
{
    use HasFactory;
    protected $table = "configuracion_email"; 
    public $timestamps = false;
}
