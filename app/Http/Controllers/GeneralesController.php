<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneralesController extends Controller
{
    function politicas_despacho()
    {
        return view("politicas-despacho");
    }

    function politicas_devolucion()
    {
        return view("politicas-devolucion");
    }

}

