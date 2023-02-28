<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComprasProductos extends Model
{
    use HasFactory;
    protected $table = "compras_productos"; 
    public $timestamps = false;
}
