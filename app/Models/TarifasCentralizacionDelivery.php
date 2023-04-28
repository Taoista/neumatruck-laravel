<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TarifasCentralizacionDelivery extends Model
{
    use HasFactory;
    protected $table = "tarifas_centralizacion_delivery"; 
    public $timestamps = false;
}
