<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MOIREI\GoogleMerchantApi\Facades\ProductApi;
use MOIREI\GoogleMerchantApi\Facades\OrderApi;


class PoliticasController extends Controller
{
    
    public function politicas_privacidad()
    {

        return view('politicas-privacidad');

    }

    function demo()
    {
        dd("hola");
    }

}
