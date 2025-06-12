<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\TestEamilMailable;
use Illuminate\Support\Facades\Mail;


class TestController extends Controller
{
    
    function send_email($email_send)
    {

        $email = strtolower($email_send);

        $correo = new TestEamilMailable($email);
        Mail::to($email)->send($correo);


        return "send email test=> ".$email;
    }

}
