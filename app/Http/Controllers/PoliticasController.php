<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PoliticasController extends Controller
{
    
    public function politicas_privacidad()
    {

        return view('politicas-privacidad');

    }

}
