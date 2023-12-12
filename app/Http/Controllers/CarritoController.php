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

        // $email = base64_decode($value);
        // $email = $value;
        // ? refresca las ession
        $time = 60 * 3;
        // $data = base64_encode($email);
        Cookie::queue("nt_session", $value, $time);

        return view("carrito");
    }

}
