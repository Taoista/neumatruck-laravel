<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfertasTipo extends Model
{
    use HasFactory;
    protected $table = "ofertas_tipo";
    public $timestamps = false;
}
