<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransbankAuxiliarController extends Controller
{
    

    function transbank_pago()
    {

        $pago = 1500;

        return view("auxiliar.auxiliar", compact('pago'));
    }


}
