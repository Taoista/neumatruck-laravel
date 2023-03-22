<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryFree extends Model
{
    use HasFactory;
    protected $table = "delivery_free"; 
    public $timestamps = false;
}
