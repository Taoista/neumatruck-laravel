<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;



class CarritoController extends Controller
{
    
    function carrito()
    {
        $value = Cookie::get('nt_session');
        if($value == null){
            return redirect('/');
        }

        return view("carrito");
    }

}
