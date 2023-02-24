<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;

class CheckoutController extends Controller
{
    function checkout()
    {
        $value = Cookie::get('nt_session');
        if($value == null){
            return redirect('/');
        }

        $email = base64_decode($value);
        // ? refresca las ession
        $time = 60 * 1;
        $data = base64_encode($email);
        Cookie::queue("nt_session", $data, $time);


        return view("checkout");
    }
}
